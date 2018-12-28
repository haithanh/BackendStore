<?php

namespace App\Console;

use App\Console\Commands\DeleteExpiredEmail;
use App\Console\Commands\DeleteExpiredFailTransaction;
use App\Console\Commands\RecallCard;
use App\Console\Commands\RecallTransaction;
use App\Console\Commands\ReportARPPU;
use App\Console\Commands\ReportGatewayRevenue;
use App\Console\Commands\ReportNRU;
use App\Console\Commands\ReportPR;
use App\Console\Commands\ReportPU;
use App\Console\Commands\ReportRevenue;
use App\Console\Commands\ReportMonthlyRevenue;
use App\Console\Commands\ReportReward;
use App\Console\Commands\ReportRewardVnd;
use App\Console\Commands\SettingTichHop;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
