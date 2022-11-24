<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSysDetail;

class UserController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'name' => 'required',
			'email' => 'required',
			'password' => 'required|confirmed',
			'security_level' => 'required',
			'docket_prefix' => 'required',
			'next_docket_number' => 'required|numeric',
			'current_office' => 'required',
			'default_office' => 'required',
		]);
		
		$user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->security_level = $request->security_level;
        $user->docket_prefix = $request->docket_prefix;
        $user->next_docket_number = $request->next_docket_number;
        $user->address = $request->address;
        $user->town = $request->town;
        $user->county = $request->county;
        $user->postcode = $request->postcode;
        $user->country = $request->country;
        $user->work_phone = $request->work_phone;
        $user->home_phone = $request->home_phone;
        $user->mobile_phone = $request->mobile_phone;
        $user->email2 = $request->email2;
        $saved = $user->save();
		
		if(!$saved) {
			return redirect('system_user_result')->with('status', 'Data Has NOT Been inserted.');
		} else {
			$targetUser = User::where('email', $request->email)->get();
			
			$userDetails = new UserSysDetail;
			$userDetails->user_id = $targetUser[0]->id;
			$userDetails->current_office = $request->current_office;
			$userDetails->default_office = $request->default_office;
			$userDetails->can_change_office = $request->can_change_office;
			//$userDetails->currently_logged_in = $request->currently_logged_in;
			$userDetails->startup_caps_lock_on = $request->startup_caps_lock_on;
			$userDetails->startup_num_lock_on = $request->startup_num_lock_on;
			$userDetails->startup_insert_on = $request->startup_insert_on;
			$userDetails->ops_code = $request->ops_code;
			$userDetails->show_mobile_data_messages = $request->show_mobile_data_messages;
			$userDetails->show_internet_bookings = $request->show_internet_bookings;
			$userDetails->show_incoming_control_emails = $request->show_incoming_control_emails;
			$userDetails->picture_file = $request->picture_file;
			$saved = $userDetails->save();

			if(!$saved) {
				return redirect('system_user_result')->with('status', 'Data has NOT been inserted.');
			} else {
				return redirect('system_user_result')->with('status', 'The new user, '.$targetUser[0]->name.', hs been inserted successfully.');
			}
		}
    }
}
