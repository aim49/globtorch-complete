<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\TeacherActivity;
use App\TeacherSubject;
use App\Payment;
use App\Enrollment;

use App\AssignmentAnswer;
use App\Subject;
use App\MessageLog;

use Illuminate\Support\Facades\Mail;
use App\Traits\MessageTrait;
use App\Mail\StudentAdded;

class MaintenancesController extends Controller
{
    use MessageTrait;

    public function run()
    {
        //$this->resetUserCredentials();
        //$this->fix_assignments();
        //$this->remove_default_email();
        //$this->delete_duplicate_accounts();
        //$this->delete_teacher_activites();
        //$this->delete_teacher_subjects();
        //$this->check_referrals();
        //$this->remove_duplicate_payments();
        $this->subjects_to_courses();
        return 'maintenance done';
    }

    public function resetUserCredentials()
    {
        $today = date('Y-m-d');
        $users = User::join('enrollments', 'users.id', 'enrollments.user_id')
            ->join('payments', 'enrollments.id', 'payments.enrollment_id')
            ->select('users.*')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('last_activity', null)
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        foreach($users as $user)
        {
            $password = substr(sha1(mt_rand()),6,6);
            $user->password = bcrypt($password);
            $user->save();

            if ($user->country == 'Zimbabwe')
            {
                $message = "Thank you for choosing Globtorch\nUser ID = " . $user->school_id . "\nPassword = " . $password . "\nLogin at www.globtorch.com\nPlease change your password on login.";
                $this->send_message($user->phone, $message);
            }
            if(filter_var($user->email, FILTER_VALIDATE_EMAIL ))
            {
                Mail::to($user->email)->send(new StudentAdded($user->school_id, $password));
            }
        
            echo $user->surname . ' ' . $user->name . ' - ' . $user->school_id . ' ' . $password . '<br>';
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'mass reset of user credentials';
        $messageLog->number = count($users);
        $messageLog->save();
    }

    /*
    *   This is a long running process and might time out
    */
    public function fix_assignments()
    {     
        $users = User::all();
        foreach($users as $user)
        {
            $courses = $user->courses->pluck('id');
            $existing_assignment_ids = AssignmentAnswer::where('user_id', $user->id)
                ->orderBy('assignment_id', 'asc')
                ->pluck('assignment_id');

            $assignment_ids = Subject::join('assignments', 'subjects.id', 'assignments.subject_id')
                ->select('assignments.*')
                ->whereIn('course_id', $courses)
                ->whereNotIn('assignments.id', $existing_assignment_ids)
                ->pluck('assignments.id');
            
            if (count($assignment_ids) > 0)
            {
                echo 'user id: ' . $user->id . '<br>';
                echo 'Existing ids: ';
                foreach($existing_assignment_ids as $id)
                {
                    echo $id . ', ';
                }
                echo '<br >';
                echo 'Non existing ids: ';
                foreach($assignment_ids as $assignment_id)
                {
                    echo $assignment_id . ', ';
                    $assignment_answer = new AssignmentAnswer;
                    $assignment_answer->user_id = $user->id;
                    $assignment_answer->assignment_id = $assignment_id;
                    $assignment_answer->save();
                }
                echo '<br></br>';
            }
        }
    }

    public function remove_duplicate_payments()
    {
        $enrollments = Enrollment::all();
        foreach($enrollments as $enrollment)
        {
            $payments = Payment::where('enrollment_id', $enrollment->id)
                ->orderBy('date')
                ->orderBy('start_date')
                ->orderBy('end_date')
                ->get();
            
            if (count($payments) > 1)
            {
                foreach($payments as $key => $payment)
                {
                    if ($key == 0)
                    {
                        $date = $payment->date;
                        $start_date = $payment->start_date;
                        $end_date = $payment->end_date;
                        $method = $payment->method;
                        $amount = $payment->amount;
                    }

                    if ($payment->date == $date && $payment->start_date == $start_date 
                        && $payment->end_date == $end_date && $payment->method == $method 
                        && $payment->amount == $amount)
                    {
                        $payment->delete();
                        echo 'payment deleted<br/>';
                    }
                    else
                    {
                        $date = $payment->date;
                        $start_date = $payment->start_date;
                        $end_date = $payment->end_date;
                        $method = $payment->method;
                        $amount = $payment->amount;
                    }
                }
            }
        }
    }

    public function remove_default_email()
    {
        User::where('email', 'example@gmail.com')->update(['email' => null]);
    }

    public function delete_duplicate_accounts()
    {
        // by email
        $users = User::select('email')->groupBy('email')
                ->havingRaw('Count(email) > 1')
                ->get();

        foreach($users as $user)
        {
            $duplicates = User::where('email', $user->email)
                ->orderBy('created_at')
                ->get();
            $this->delete_duplicates($user, $duplicates);
        }

        //by phone
        $users = User::select('phone')->groupBy('phone')
                ->havingRaw('Count(phone) > 1')
                ->get();
        foreach($users as $user)
        {
            $duplicates = User::where('phone', $user->phone)
                ->orderBy('created_at')
                ->get();
            $this->delete_duplicates($user, $duplicates);
        }

        //by name and surname
        $users = User::select('surname', 'name')->groupBy('surname', 'name')
                ->havingRaw('Count(surname) > 1')
                ->get();
        foreach($users as $user)
        {
            $duplicates = User::where([
                ['surname', $user->surname],
                ['name', $user->name]
                ])
                ->orderBy('created_at')
                ->get();
            $this->delete_duplicates($user, $duplicates);
        }
    }

    public function delete_duplicates($user, $duplicates)
    {
        $num_duplicates = count($duplicates) - 1;
        $skipped = 0;
        foreach ($duplicates as $key => $duplicate)
        {
            $referrals = User::where('referrer', $duplicate->school_id)->get();
            if($duplicate->last_activity == null && count($user->courses) == 0 && count($referrals) == 0)
            {
                if ($key < $num_duplicates || $skipped > 0)
                {
                    $duplicate->delete();
                    echo 'account deleted<br />';
                }
                else
                {
                    echo 'account skipped<br />';
                }
            }
            else
            {
                $skipped = $skipped + 1;
            }
        }
    }

    public function delete_teacher_activites()
    {
        $teacher_activities = TeacherActivity::doesntHave('user')->delete();
    }

    public function delete_teacher_subjects()
    {
        $teacher_subjects = TeacherSubject::doesntHave('user')->delete();
    }

    public function check_referrals()
    {
        $users = User::whereNotNull('referrer')->get();
        foreach($users as $user)
        {
            $referrer = User::where('school_id', $user->referrer)->get();
            if (count($referrer) == 0)
            {
                echo 'fixed referrer: ' . $user->referrer . ' . <br/>';
                $user->referrer = null;
                $user->save();
            }
        }
    }

    /**
     * One time function meant to change course to subjects
     * from one to many to many to many
     * assign the subjects to their respective courses
     */
    public function subjects_to_courses()
    {
        $subjects = Subject::all();
        foreach($subjects as $subject)
        {
            $subject->courses()->attach($subject->course_id);
        }
    }
}
