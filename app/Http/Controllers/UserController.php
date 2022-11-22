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
			'security_level_id' => 'required|numeric',
			'docket_prefix' => 'required',
			'next_docket_number' => 'required|numeric',
		]);
		
		$user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->security_level_id = $request->security_level_id;
        $user->docket_prefix = $request->docket_prefix;
        $user->next_docket_number = $request->next_docket_number;
        $saved = $user->save();
		
		if(!$saved) {
			return redirect('system_user_add_result')->with('status', 'Data Has NOT Been inserted');
		} else {
/* 			$saved = $userDetails->save();
			$userDetails->name = $request->name;
			$userDetails = new UserSysDetail;
 */
			return redirect('system_user_add_result')->with('status', 'Data Has Been inserted');
		}
    }
}
