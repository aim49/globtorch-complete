<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Payment;
use App\Course;
use App\Paynow;
use App\Enrollment;
use App\User;
use App\Commission;
use App\MessageLog;

use Carbon\Carbon;

use App\AssignmentAnswer;

use App\Traits\NotificationTrait;
use App\Traits\MessageTrait;
use App\Traits\UserTrait;

class PaymentController extends Controller
{
    use UserTrait;
    use NotificationTrait;
    use MessageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id -> course_id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //getting the course that has the id
        $course = Course::find($id);
        $price = $this->getPrice($course, 1);
        return view('payments.create', compact( 'course', 'price'));
    }

    /**
     * isDisplay = 1 when showing to customers, 0 when calculating
     */
    public function getPrice($course, $isDisplay)
    {
        if ($isDisplay)
        {
            if ($course->level == 'Primary')
            {
                $price = 5*100 . ' RTGS/Year';
            }
            else if ($course->level == 'Secondary')
            {
                $price = 10*100 . ' RTGS/Year';
            }
            else if ($course->level == 'Tertiary')
            {
                $price = 15*100 .  ' RTGS/6 Months';
            }
        }
        else
        {
            if ($course->level == 'Primary')
            {
                $price = 5*100;
            }
            else if ($course->level == 'Secondary')
            {
                $price = 10*100;
            }
            else if ($course->level == 'Tertiary')
            {
                $price = 15*100;
            }
        }
        /*
        $prices = array();
        if ($isDisplay)
        {
            $prices[1] = '1 month: $' . $course->price;
            $prices[3] = '3 months: $' .  $this->getDiscountedPrice($course->price, 3, 10) . ' - 10% off!';
            $prices[6] = '6 months: $' . $this->getDiscountedPrice($course->price, 6, 15) . ' -15% off!';
            $prices[12] = '12 months: $' . $this->getDiscountedPrice($course->price, 12, 25) . ' -25% off!';
        }
        else
        {
            $prices[1] = $course->price;
            $prices[3] = $this->getDiscountedPrice($course->price, 3, 10);
            $prices[6] = $this->getDiscountedPrice($course->price, 6, 15);
            $prices[12] = $this->getDiscountedPrice($course->price, 12, 25);
        }
        */
        return $price;
    }

    public function getDiscountedPrice($price, $period, $percentage)
    {
        $discountedPrice = ($price * $period) - ($price * $period * $percentage / 100);
        return $discountedPrice;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function store($course_id,$date,$start_date,$end_date,$method,$price,$enrollment_id,$user_id,$ref)
    {
        if($enrollment_id == 0)
        {
            // search if this enrollment already exists
            $enrollment_search = Enrollment::where([['user_id', $user_id], ['course_id', $course_id]])->get();
            if (count($enrollment_search) > 0)
            {
                $enrollment = $enrollment_search[0];
            }
            else
            {
                // add new enrollment
                $enrollment = new Enrollment;
                $enrollment->user_id = $user_id;
                $enrollment->course_id = $course_id;
                $enrollment->status = 'Active';
                $enrollment->save();

                // add assignments
                $this->add_user_to_assignments($user_id, $course_id);
            }
            $enroll = $enrollment->id;
        }
        else
        {
            $enroll = $enrollment_id;
        }
        //add payment to database
        $result = array();
        try 
        {
            $payments = Payment::where([
                ['date', $date],
                ['start_date', $start_date],
                ['end_date', $end_date],
                ['method', $method],
                ['amount', $price],
                ['enrollment_id', $enroll]
            ])->get();
            if (count($payments) > 0)
            {
                $result["status"] = 'Payment exists';
                return $result;
            }
            $payment = new Payment;
            $payment->date = $date;
            $payment->start_date = $start_date;
            $payment->end_date = $end_date;
            $payment->method = $method;
            $payment->amount = $price;
            $payment->enrollment_id = $enroll;
            $payment->save();
            $result["status"] = "ok";

            $this->add_commission($user_id, $price);
            $this->notify_admin($user_id, $enroll);
        } 
        catch (Exception $ex) 
        {
            $result["status"] = $ex->getMessage();
        }
        return $result;  
    }

    public function add_commission($user_id, $amount)
    {
        //commission is 20% of the total amount
        $commission_amount = $amount * 0.20;

        $user = User::find($user_id);
        if ($user->referrer != null)
        {
            //referrer exists, check dates
            if ($user->created_at >= Carbon::now()->subMonths(3))
            {
                $month = date('m');
                $referrer = User::where('school_id', $user->referrer)->get()->first();

                //check if there is commission for this month already
                $commission = Commission::where('user_id', $referrer->id)
                    ->where('month', $month)
                    ->get()->first();
                if ($commission != null)
                {
                    $commission->amount = $commission->amount + $commission_amount;
                }
                else
                {
                    $commission = new Commission;
                    $commission->month = $month;
                    $commission->amount = $commission_amount;
                    $commission->user_id = $referrer->id;
                }
                $commission->save();
            }
        }
    }

    /**
     * Function to handle the request of the user to purchase a course
     * Redirects user to paynow to complete payment
     */
    public function initiate_payment(Request $request)
    {
        $course = Course::find($request->input('id'));
        $payment_date= date("Y/m/d");
        $start_date = $request->input('start_date');
        //$period = $request->input('period');
        if ($course->level == 'Tertiary')
        {
            $period = 6;
        }
        else
        {
            $period = 12;
        }

        $total_price = $this->getPrice($course, 0);
        $user_id= Auth::user()->id;
        $fullname=Auth::user()->name . " ". Auth::user()->surname ;
        $enrollment_id = 0;

        $ref =  Auth::user()->school_id .$course->id.time();
        $return_url =  'https://globtorch.com/payment_successful/'.$ref;
        $result_url = 'https://globtorch.com/payment_update/'.$ref;
        
        /* PETER'S PAYNOW */
        // $paynow_integration_id = 6283;
        // $paynow_integration_key = 'a288786a-c2a2-46cd-b946-d07b68c06db3';   
        
        /* GLOBTORCH PAYNOW */
        $paynow_integration_id = 7281;
        $paynow_integration_key = '60815208-3fc2-4826-b7ba-f8667c0b4e97';
        
        $paynow = new \Paynow\Payments\Paynow(
            $paynow_integration_id,
            $paynow_integration_key,
            $return_url,
            $result_url
        );       
        $payment = $paynow->createPayment($ref, 'payments@globtorch.com');//email is optional
        $payment->add('You are about to pay '.$total_price.' for '.$course->name.' for a period of ' . $period . ' months', $total_price);

        if ($request->input('payment_type') == 'ecocash')
        {
            $response = $paynow->sendMobile($payment, $request->input('phone'), 'ecocash');
            if(!$response->success()) 
            {
                die('Paynow error');
            }
            $instructions = $response->instructions();
        }
        else
        {
            $response = $paynow->send($payment);
            if(!$response->success()) 
            {
                die('Paynow error');
            }
            $redirectUrl = $response->redirectUrl(); 
        }
        $pollUrl = $response->pollUrl();

        //save the poll
        $paynow=new Paynow();
        $paynow->ref=$ref;
        $paynow->url=$pollUrl;
        $paynow->course_id=$course->id;
        $paynow->user_id=$user_id;
        $paynow->enrollment_id=$enrollment_id;  //we possibly do not need this here since it's recorded on the payments table
        $paynow->payment_date=$payment_date;
        $paynow->start_date=$start_date;
        $paynow->period=$period;
        $paynow->save();

        if ($request->input('payment_type') == 'ecocash')
        {
            return view('payments.ecocash_instruction', compact('instructions', 'ref'));
        }
        else
        {
            return redirect($redirectUrl);
        }
    }

    /**
     * Function that handles the payment after coming from paynow
     */
    public function payment_successful($ref)
    {
        $paynow_record = Paynow::where('ref', $ref)->get()->first();
        /* PETER'S PAYNOW */
       // $paynow_integration_id = 6283;
       // $paynow_integration_key = 'a288786a-c2a2-46cd-b946-d07b68c06db3'; 
        
       /* GLOBTORCH PAYNOW */
        $paynow_integration_id = 7281;
        $paynow_integration_key = '60815208-3fc2-4826-b7ba-f8667c0b4e97';
       
        $paynow = new \Paynow\Payments\Paynow(
            $paynow_integration_id,
            $paynow_integration_key,
            'http://example.com/gateways/paynow/update',
            'http://example.com/gateways/paynow/update');

        //check with paynow to get status of the payment
        $status = $paynow->pollTransaction($paynow_record->url);
        $date= date("Y/m/d");
        $start_date =$paynow_record->start_date;
        $period = $paynow_record->period .' month';
        $end_date= date("Y-m-d", strtotime($period, strtotime( $start_date)));
        $method="Paynow";
        $price = $status->amount();
        $enrollment_id =$paynow_record->enrollment_id;
        $user_id= $paynow_record->user_id;
        $course_id= $paynow_record->course_id;

        if($status->status() =='paid' || $status->status() =='awaiting delivery') 
        {
            $payment = $this->store($course_id,$date,$start_date,$end_date,$method,$price,$enrollment_id,$user_id,$ref);
            if($payment['status']=="ok")
            {
                return redirect('/enrollment')->with('message','Payment was successfully made');
            }
            elseif(($payment['status']=="fail"))
            {
                return redirect('/enrollment')->with('message','Payment failed to be recorded. Contact Admin :078 425 3714 <br>Ref: ' . $ref);
            }
        } 
        else 
        {
            return redirect('/enrollment')->withErrors('No payment received. Contact Admin : 078 425 3714 with the confirmation of payment');
        }
    }

    /**
     * Function that handles the payment update
     */
    public function payment_update($ref)
    {
        // Create a new paynow object passing in your integration keys (used for validating the hash of the status update)
        $paynow = new Paynow(
            ' 6378',
            '02a11c42-1276-4a37-8b3c-fb415335e368',
            null, null);
        try 
        {
            // Process the incoming status update
            $status = $paynow->processStatusUpdate();
        
            
            // Get the reference of the transaction you sent with the transaction when you initiated it
            // @see https://developers.paynow.co.zw/docs/sourcedocs_php.html#class-paynow-core-statusresponse
            $reference = $status->reference();
            
            // Check if the transaction was paid for 
            if($status->paid())
            {
                // This user showed us dat doe. Better give them whatever they paid for 
                
                // On the real. Here you might want to update the transaction with the reference '$reference'
                // in your DB. Set it's status as paid
            }
            else
            {
                // We got some other status from Paynow. Handle that
                // For the full list of the statuses that can be returned by Paynow, see https://developers.paynow.co.zw/docs/status_update.html
                $state = $reference->status();
            
                // Update the transaction's status in your DB maybe?
            }
            
        } 
        catch (\Exception $e) 
        {
        // *scream* ahhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
        // something broke. log this? 
        }
    }

    public function create_manual_payment()
    {
        return view('payments.create_manual');
    }

    public function accept_manual_payment(Request $request)
    {
        $user_id = $request->input('user_id');
        $course_code = $request->input('course_code');
        $payment_date = $request->input('payment_date');
        $start_date = $request->input('start_date');
        $method = $request->input('method');
        $price = $request->input('price');
        $period = $request->input('period') . ' month';
        $total_price = $request->input('total_price');
        $end_date= date("Y-m-d", strtotime($period, strtotime( $start_date)));
        $ref = $request->input('ref');

        $course = Course::where('code', $course_code)->get()->first();
        $user = User::where('school_id', $user_id)->get()->first();
        $payment = $this->store($course->id,$payment_date,$start_date,$end_date,$method,$total_price,0,$user->id,$ref);
        if($payment['status']=="ok")
        {
            return back()->with('message','Payment was successfully made');
        }
        elseif(($payment['status']=="fail"))
        {
            return back()->with('message','Payment failed to be recorded. Contact IT department');
        }
        elseif(($payment['status'] == 'Payment exists'))
        {
            return back()->withErrors('Payment already exists');
        }
    }

    public function instructions()
    {
        return view('payments.instructions');
    }

    public function add_user_to_assignments($user_id, $course_id)
    {
        $course = Course::find($course_id);
        foreach($course->subjects as $subject)
        {
            foreach($subject->assignments as $assignment)
            {
                $assignment_answer = new AssignmentAnswer;
                $assignment_answer->user_id = $user_id;
                $assignment_answer->assignment_id = $assignment->id;
                $assignment_answer->save();
            }
        }
    }

    /**
     * Notify admin that a student paid
     */
    public function notify_admin($user_id, $enroll)
    {
        $users = User::where('user_type', 'admin')->get();
        $student = User::find($user_id);
        $enrollment = Enrollment::where('id', $enroll)->get()->first();
        $course = $enrollment->course;
        $message = $student->surname . ' ' . $student->name . ' has made payment for ' . $course->name;

        foreach($users as $user)
        {
            $this->send_message($user->phone, $message);
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'notify admin of enrollment';
        $messageLog->number = count($users);
        $messageLog->save();
    }

    public function registrationFee(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        session(['course_id' => $course_id]);
        if ($course->level == 'Primary')
        {
            $total_price = 5*100;
        }
        elseif ($course->level == 'Secondary')
        {
            $total_price = 10*100;
        }
        elseif ($course->level == 'Tertiary')
        {
            $total_price = 15*100;
        }
        
        $ref =  'registration'.time();
        $return_url =  'https://globtorch.com/reg_payment_successful/'.$ref;
        $result_url = 'https://globtorch.com/payment_update/'.$ref;

        $paynow_integration_id = 7281;
        $paynow_integration_key = '60815208-3fc2-4826-b7ba-f8667c0b4e97';
        
        $paynow = new \Paynow\Payments\Paynow(
            $paynow_integration_id,
            $paynow_integration_key,
            $return_url,
            $result_url
        );       
        $payment = $paynow->createPayment($ref, 'payments@globtorch.com');//email is optional
        $payment->add('You are about to pay '.$total_price.' for registration', $total_price);

        if ($request->input('payment_type') == 'ecocash')
        {
            $response = $paynow->sendMobile($payment, $request->input('phone'), 'ecocash');
            if(!$response->success()) 
            {
                die('Paynow error');
            }
            $instructions = $response->instructions();
        }
        else
        {
            $response = $paynow->send($payment);
            if(!$response->success()) 
            {
                die('Paynow error');
            }
            $redirectUrl = $response->redirectUrl(); 
        }
        $pollUrl = $response->pollUrl();

        //save the poll
        $paynow=new Paynow();
        $paynow->ref=$ref;
        $paynow->url=$pollUrl;
        $paynow->course_id=0;
        $paynow->user_id=0;
        $paynow->enrollment_id=0;  //we possibly do not need this here since it's recorded on the payments table
        $paynow->payment_date=date("Y/m/d");;
        $paynow->start_date=date("Y/m/d");;
        $paynow->period=0;
        $paynow->save();

        if ($request->input('payment_type') == 'ecocash')
        {
            return view('payments.registration_ecocash', compact('instructions', 'ref'));
        }
        else
        {
            return redirect($redirectUrl);
        }
    }

    /**
     * Function that handles the payment after coming from paynow
     */
    public function registrationPaymentSuccessful($ref)
    {
        $paynow_record = Paynow::where('ref', $ref)->get()->first();
        $paynow_integration_id = 7281;
        $paynow_integration_key = '60815208-3fc2-4826-b7ba-f8667c0b4e97';
        $paynow = new \Paynow\Payments\Paynow(
            $paynow_integration_id,
            $paynow_integration_key,
            'http://example.com/gateways/paynow/update',
            'http://example.com/gateways/paynow/update');
        $status = $paynow->pollTransaction($paynow_record->url);
        $date= date("Y/m/d");
        if($status->status() =='paid' || $status->status() =='awaiting delivery') 
        {
            $user = new User;
            $user->name = session('name');
            $user->surname = session('surname');
            $user->phone = session('phone');
            $user->email = session('email');
            $user->country = session('country');
            $user->password = session('password');
            $user->school_id = $this->get_user_id('student');
            $user->user_type = 'student';
            $user->referrer = session('referral');
            $user->institution_id = session('institution_id');
            $user->save();  

            $course = Course::findOrFail(session('course_id'));
            if($course->level == 'Primary')
            {
                $period = '12 month';
                $price = 5*100;
            }   
            else if ($course->level == 'Secondary')
            {
                $period = '12 month';
                $price = 10*100;
            }         
            else if ($course->level == 'Tertiary')
            {
                $period = '6 month';  
                $price = 15*100;           
            }
            $end_date= date("Y-m-d", strtotime($period, strtotime( $date)));
            $payment = $this->store($course->id,
                $date,$date,$end_date,'paynow',$price,0,$user->id,$ref);
        } 
        else 
        {
            return redirect('/signin')->withErrors('No payment received. Contact Admin : 078 425 3714 with the confirmation of payment');
        }
        return redirect('/signin')->with('message', 'You have successfully registered. Your user ID is ' . $user->school_id);
    }
}
