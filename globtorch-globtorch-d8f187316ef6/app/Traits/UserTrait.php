<?php

namespace App\Traits;

use App\User;

trait UserTrait
{
    protected function get_user_id($user_type)
    {
        //  getting the last user added into the system
        $last_user = User::where('user_type', $user_type)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $user_id = $this->get_prefix($last_user->user_type);

        if ($last_user == null)
        {
            //he is the first user
            $user_id = $user_id . '0001';
        }
        else
        {
            do
            {
                $user_id = $this->get_prefix($last_user->user_type);
                $numbers = (int)substr($last_user->school_id, 2);
                $numbers++;

                $leading_zeros = 0;
                if ($numbers < 10)
                {
                    $leading_zeros = 3;
                }
                else if ($numbers < 100)
                {
                    $leading_zeros = 2;
                }
                else if ($numbers < 1000)
                {
                    $leading_zeros = 1;
                }
                for ($x = 0; $x < $leading_zeros; $x++)
                {
                    $user_id = $user_id . '0';
                }
                $user_id = $user_id . $numbers;
                $last_user = User::where('school_id', $user_id)->get()->first();
            }while($last_user != null);
        }
        return ($user_id);
    }

    private function get_prefix($user_type)
    {
        //adding a prefix depending on the user type
        if ($user_type == 'admin')
        {
            $user_id = 'GA';
        }
        else if ($user_type == 'teacher')
        {
            $user_id = 'GT';
        }
        else if ($user_type == 'student')
        {
            $user_id = 'GS';
        }
        else
        {
            return 0;
        }

        return $user_id;
    }
}
?>