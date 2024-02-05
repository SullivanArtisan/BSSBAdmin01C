<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ContainerController;
use App\Helper\MyHelper;
use App\Models\Container;
use App\Models\Booking;
use App\Models\container_completed;
use App\Models\Driver;


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
        $schedule->call(function () {
            // Check if there's any container which is just completed by the driver. If so, change the container's and the corresponding booking's status
			$done_containers = \App\Models\container_completed::where('ccntnr_received', 'N')->get();
			foreach ($done_containers as $done_container) {
				$container = Container::where('id', $done_container->ccntnr_id)->first();
				$container->cntnr_status = MyHelper::CntnrCompletedStaus();
				$container->cntnr_completed_on = date("Y-m-d H:i:s");
				$container->save();
		
				Log::Info("The Kernel's schedule is going to receive the completed job for container ".$container->cntnr_name);

				$booking = Booking::where('id', $done_container->ccntnr_job_id)->first();
				ContainerController::UpdateBookingStatus($booking);

				$done_container->ccntnr_received = 'Y';
				$done_container->save();
			}
        })->everyMinute();
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
