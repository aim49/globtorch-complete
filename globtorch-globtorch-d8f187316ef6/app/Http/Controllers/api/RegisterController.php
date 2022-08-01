<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Payment;
use App\Course;
use App\Paynow;
use App\Enrollment;
use App\User;
use App\Commission;
use App\MessageLog;
use App\AssignmentAnswer;
use App\LoginHistory;

use App\Traits\NotificationTrait;
use App\Traits\MessageTrait;
use App\Traits\UserTrait;

class RegisterController extends Controller
{
    use UserTrait;
    use NotificationTrait;
    use MessageTrait;

    public function register(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'surname'=>'required',
            'phone'=>'required|unique:users',
            'email'=>'email|nullable|unique:users',
            'country' => 'required',
            'password'=>'required',
            'institution_id' => 'integer|nullable',
            'course_id' => 'required|integer',
            'paynow_ref' => 'required|string'
        ]);

        $password = $request->input('password');
        $user = new User;
        $user->surname = $request->input('surname');
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->country = $request->input('country');
        $user->password = bcrypt($password);
        $user->institution_id = $request->input('institution_id');
        $user->school_id = $this->get_user_id('student');
        $user->user_type = 'student';
        $user->save();
        
        $course = Course::findOrFail($request->input('course_id'));
        $date = date("Y/m/d");
        $ref = $request->input('paynow_ref');
        if($course->level == 'Primary')
        {
            $period = '12 month';
            $price = 80;
        }   
        else if ($course->level == 'Secondary')
        {
            $period = '12 month';
            $price = 100;
        }         
        else if ($course->level == 'Tertiary')
        {
            $period = '6 month';  
            $price = 200;           
        }
        $end_date= date("Y-m-d", strtotime($period, strtotime( $date)));
        $payment = $this->storePayment($course->id,
            $date,$date,$end_date,'paynow',$price,0,$user->id,$ref);
        $remember = 0;
        if(Auth::attempt(['school_id' => $user->school_id, 'password' => $password], $remember))
        {
            $login_history = new LoginHistory;
            $login_history->user_id = Auth::user()->id;
            $login_history->save();
            Auth::user()->generateToken();
            return response()->json(['data' => Auth::user()->toArray()], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Internal Server Error',
                'errors' => ['register' => 'Oops something went wrong.']
            ], 500);
        }
    }

    public function inititatePayment(Request $request)
    {
        $this->validate($request,[
            'phone'=>'required',
            'course_id' => 'required|integer'
        ]);

        $course = Course::findOrFail($request->input('course_id'));
        if ($course->level == 'Primary')
        {
            $total_price = 80;
        }
        elseif ($course->level == 'Secondary')
        {
            $total_price = 100;
        }
        elseif ($course->level == 'Tertiary')
        {
            $total_price = 200;
        }
        
        $ref =  'registration'.time();
        $return_url =  route('api.register.payment.successful', [$ref]);
        $result_url = 'https://globtorch.com/api/payment_update/'.$ref;

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
        $response = $paynow->sendMobile($payment, $request->input('phone'), 'ecocash');
        if(!$response->success()) 
        {
            return response()->json([
                'message' => 'Unknown error',
                'errors' => ['register' => 'Unable to process payment']
            ], 400);
        }
        $instructions = $response->instructions();
        $pollUrl = $response->pollUrl();

        $paynow=new Paynow();
        $paynow->ref=$ref;
        $paynow->url=$pollUrl;
        $paynow->course_id=0;
        $paynow->user_id=0;
        $paynow->enrollment_id=0;
        $paynow->payment_date=date("Y/m/d");;
        $paynow->start_date=date("Y/m/d");;
        $paynow->period=0;
        $paynow->save();

        return response()->json(['data' => $instructions, 'url' => $return_url], 200);
    }

    public function paymentSuccessful($ref)
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
        if($status->status() =='paid' || $status->status() =='awaiting delivery') 
        {
            return response()->json(['reference' => $ref], 200);
        } 
        else 
        {
            return response()->json([
                'message' => 'Please try again or contact Admin : 078 425 3714 with the confirmation of payment',
                'errors' => ['register' => 'No payment received']
            ], 400);
        }
    }

    private function storePayment($course_id,$date,$start_date,$end_date,$method,$price,$enrollment_id,$user_id,$ref)
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
}
