<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Peter';
        $user->surname = 'Tsai';
        $user->gender = 'male';
        $user->address = 'some address';
        $user->dob = '1993-02-19';
        $user->city = 'Harare';
        $user->country = 'Zimbabwe';
        $user->phone = '0783172013';
        $user->email = 'hyptsai@gmail.com';
        $user->school_id = 'GA0001';
        $user->password = bcrypt('password');
        $user->user_type = 'admin';
        $user->isEnabled = 1;
        $user->save();

        $user = new User;
        $user->name = 'Chipo';
        $user->surname = 'Tsai';
        $user->gender = 'female';
        $user->address = 'some address';
        $user->dob = '1994-02-19';
        $user->city = 'Harare';
        $user->country = 'Zimbabwe';
        $user->phone = '0783172013';
        $user->email = 'hyptsai@gmail.com';
        $user->school_id = 'GT0001';
        $user->password = bcrypt('password');
        $user->user_type = 'teacher';
        $user->isEnabled = 1;
        $user->save();

        $user = new User;
        $user->name = 'Edward';
        $user->surname = 'Tsai';
        $user->gender = 'male';
        $user->address = 'some address';
        $user->dob = '1991-12-30';
        $user->city = 'Harare';
        $user->country = 'Zimbabwe';
        $user->phone = '0783172013';
        $user->email = 'hyptsai@gmail.com';
        $user->school_id = 'GS0001';
        $user->password = bcrypt('password');
        $user->user_type = 'student';
        $user->isEnabled = 1;
        $user->save();
    }
}
