<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if(\App\HorizontCMS::isInstalled()){
            foreach(\App\Model\ScheduledTask::where('active',1)->get() as $task){
                $schedule->command($task->command)->cron($task->frequency)->before(function() use ($task) {
                    \Log::info("Scheduled run : ".$task->name." [".$task->command."]");
                })->pingBefore($task->ping_before)->thenPing($task->ping_after)->withoutOverlapping();
            }
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
