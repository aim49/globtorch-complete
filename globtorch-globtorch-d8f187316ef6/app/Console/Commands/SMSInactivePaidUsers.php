<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Traits\MessageTrait;
use App\User;
use App\MessageLog;
use Carbon\Carbon;

class SMSInactivePaidUsers extends Command
{

    use MessageTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:inactive-paid-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SMS users who have paid but not logged in';

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
        $today = date('Y-m-d');
        $limit = Carbon::now()->subDay(2);
        $users = User::join('enrollments', 'enrollments.user_id', 'users.id')
            ->join('payments', 'payments.enrollment_id', 'enrollments.id')
            ->select('users.*')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('last_activity', '<', $limit)
            ->distinct()
            ->get();
        foreach($users as $user)
        {
            $this->send_message($user->phone, 'Hi. A reminder to login and study. Make the most of our services that you have purchased. globtorch.com/login - Thank you for using our platform.');
        }
        $messageLog = new MessageLog;
        $messageLog->purpose = 'login reminder - paid students';
        $messageLog->number = count($users);
        $messageLog->save();
    }
}
