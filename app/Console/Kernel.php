<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// use Illuminate\Support\Facades\Log;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

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
			// Example of using PHPMailer package directly
			// Log::info('Schedule going to send email....');
			// $mail = new PHPMailer(true);

			// //Enable SMTP debugging.
			// // $mail->SMTPDebug = 3;                               
			// //Set PHPMailer to use SMTP.
			// $mail->isSMTP();            
			// //Set SMTP host name                          
			// $mail->Host = "smtp.gmail.com";
			// //Set this to true if SMTP host requires authentication to send email
			// $mail->SMTPAuth = true;                          
			// //Provide username and password     
			// $mail->Username = "nuecosoftware@gmail.com";                 
			// $mail->Password = "uqxsdttvfmajplvh";                           
			// //If SMTP requires TLS encryption then set it
			// $mail->SMTPSecure = "tls";                           
			// //Set TCP port to connect to
			// $mail->Port = 587;                                   

			// $mail->From = "nuecosoftware@gmail.com";
			// $mail->FromName = "HOHOHO";

			// $mail->addAddress("nuecosoftware@gmail.com", "HAHAHA");

			// $mail->isHTML(false);

			// $mail->Subject = "Laravel Testing Mail in text mode";
			// $mail->Body = "How are you today?";
			// // $mail->AltBody = "This is the plain text version of the email content";

			// try {
				// $mail->send();
				// Log::info("Message has been sent successfully");
			// } catch (Exception $e) {
				// Log::info("Mailer Error: " . $mail->ErrorInfo);
			// }
			
			// Example of using my own facade which just uses the PHPMailer package
			\PhpMailerProxy::SendBasicEmail("nuecosoftware@gmail.com",
							"uqxsdttvfmajplvh",
							"nuecosoftware@gmail.com",
							"HYang",
							"nuecosoftware@gmail.com",
							"Laravel Testing4 Mail in text mode",
							"How are you today????");
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
