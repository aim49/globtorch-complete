<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Traits\MessageTrait;
use App\User;
use App\MessageLog;
use Carbon\Carbon;

class SMSInactiveUsers extends Command
{
    use MessageTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending smses to inactive users';

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
        $limit = Carbon::now()->subDay(7);
        $users = User::where('last_activity', '<', $limit)->get();
        foreach($users as $user)
        {
            $this->send_message($user->phone, 'Hi. You have not been using our website for a long time. Please log in. globtorch.com/login - Thank you for joining our online education platform.');
        }

        $users = User::where('last_activity', null)->get();
        foreach($users as $user)
        {
            $this->send_message($user->phone, 'Hi. You have not been using our website for a long time. Please log in. globtorch.com/login - Thank you for joining our online education platform.');
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'login reminder - unpaid students';
        $messageLog->number = count($users);
        $messageLog->save();
    }
}
