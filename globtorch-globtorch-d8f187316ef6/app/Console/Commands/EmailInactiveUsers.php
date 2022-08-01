<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Notifications\UserNotifications;
use App\User;

class EmailInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending email to inactive users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subject = 'Login Reminder';
        $introduction = 'Hi. You have not been using our website for a long time. Please log in.';
        $notification_action = 'Login';
        $notification_url = route('login');
        $conclusion = 'Thank you for studying with us';

        $limit = Carbon::now()->subDay(7);
        $users = User::where('last_activity', '<', $limit)->get();
        foreach($users as $user)
        {
            $user->notify(new UserNotifications($subject, $introduction, $notification_action, $notification_url, $conclusion));
        }

        $users = User::where('last_activity', null)->get();
        foreach($users as $user)
        {
            $user->notify(new UserNotifications($subject, $introduction, $notification_action, $notification_url, $conclusion));
        }
    }
}
