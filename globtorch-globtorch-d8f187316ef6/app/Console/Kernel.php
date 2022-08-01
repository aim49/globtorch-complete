<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Traits\MessageTrait;
use App\User;

use App\Console\Commands\EmailInactiveUsers;
use App\Console\Commands\SMSInactiveUsers;
use App\Console\Commands\SMSInactivePaidUsers;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SMSInactiveUsers::class,
        EmailInactiveUsers::class,
        SMSInactivePaidUsers::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*
        $schedule->command('sms:inactive-users')->monthlyOn(1, '8:00'); //every month on the 1st at 10am
        $schedule->command('sms:inactive-users')->monthlyOn(15, '8:00'); //every month on the 11th at 10am
        */
        $schedule->command('email:inactive-user')->dailyAt('10:00'); //everyday at 10am

        //smses to paid inactive students
        $schedule->command('sms:inactive-paid-users')->weeklyOn(1, '9:00'); //monday
        $schedule->command('sms:inactive-paid-users')->weeklyOn(3, '9:00'); //wednesday
        $schedule->command('sms:inactive-paid-users')->weeklyOn(5, '9:00'); //friday
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
