<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
// use App\Http\Controllers\Controller;
	class MailController extends Controller {
	   const TO_ADDR = "nuecosoftware@gmail.com";
	   
	   public function basic_email(Request $request) {
		  $data = array('name'=>"Hans Yang");
			Mail::to(self::TO_ADDR);
		  Mail::send(['text'=>'mail'], $data, function($message) {
			 $message->subject('Laravel Basic Text Testing Mail');
		  });
		  echo "Basic Email Sent 2. Check your inbox.";
	   }
	   
	   public function html_email(Request $request) {
		  $data = array('name'=>"Hans Yang 2");
		  Mail::send('mail', $data, function($message) {
			 $message->to(self::TO_ADDR, 'Tutorials Point')->subject('Laravel HTML Testing Mail');
		  });
		  echo "HTML Email Sent. Check your inbox.";
	   }
	   
	   public function attachment_email(Request $request) {
		  $data = array('name'=>"Hans Yang 3");
		  Mail::send('mail', $data, function($message) {
			 $message->to(self::TO_ADDR, 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
			 $message->attach('C:\laragon\www\BSSBAdmin01C\public\assets\img\dogs\image2.jpeg');
		  });
		  echo "Email Sent with attachment. Check your inbox.";
	   }
	}
?>