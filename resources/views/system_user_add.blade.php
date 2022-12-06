<?php
	use App\Models\User;
	use App\Models\UserSysDetail;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('system_user_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<?php
		$picPath = Session::get('uploadPath');
		Session::forget(['uploadPath']);
	?>
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New System User</h2>
	</div>
    <div>
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
        <div class="row">
            <div class="col">
                <form method="post" action="{{url('system_user_result')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Name:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="name"></div>
                        <div class="col"><label class="col-form-label">Current Office:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="current_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="email" name="email"></div>
                        <div class="col"><label class="col-form-label">Default Office:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="default_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Password:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="password" name="password"></div>
                        <div class="col"><label class="col-form-label">Can Change Office:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="can_change_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Confirm Password:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="password" name="password_confirmation"></div>
                        <div class="col"><label class="col-form-label">Startup Caps Lock On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="startup_caps_lock_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Security Level:</label></div>
						<!--
                        <div class="col"><input class="form-range form-control" type="range" name="security_level_id"></div>
						-->
						<div class="col">
							<input list="security_level" name="security_level" id="secLevelInput" class="form-control mt-1 my-text-height">
							<datalist id="security_level">
							<option value="Full Security">
							<option value="Admin">
							<option value="Operations Supervisor">
							<option value="Dispatch-Coordinator">
							<option value="Chassis">
							<option value="TIDEWATER-USERS">
							<option value="Accounting">
							<option value="Safety">
							<option value="Gatehouse">
							</datalist>
						</div>
                        <div class="col"><label class="col-form-label">Startup Num Lock On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="startup_num_lock_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Docket Prefix:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="docket_prefix"></div>
                        <div class="col"><label class="col-form-label">Startup Insert On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="startup_insert_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Next Docket Number:&nbsp;&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="next_docket_number"></div>
                        <div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
						<!--
                        <div class="col"><input class="form-range form-control" type="range" name="ops_code"></div>
						-->
						<div class="col">
							<input list="ops_code" name="ops_code" id="opsCodeInput" class="form-control mt-1 my-text-height">
							<datalist id="ops_code">
							<option value="Local">
							<option value="Highway">
							<option value="Admin">
							</datalist>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="address"></div>
                        <div class="col"><label class="col-form-label">Show Mobile Data Messages:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="show_mobile_data_messages"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Town:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="town"></div>
                        <div class="col"><label class="col-form-label">Show Internet Bookings:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="show_internet_bookings"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">County:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="county"></div>
                        <div class="col"><label class="col-form-label">Show Incoming Control Emails:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" name="show_incoming_control_emails"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Postcode:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="postcode"></div>
                        <div class="col"><label class="col-form-label">Picture File:&nbsp;</label></div>
						<div class="col">
							<div class="row">
								<div class="col-9 pr-0"><input class="form-control mt-1 my-text-height" type="text" id="picture_file" name="picture_file"></div>
								<div class="col-3 pl-2"><button class="btn btn-secondary btn-sm mt-1" type="button"><a href="{{route('system_user_pic_upload')}}">Upload</a></button></div>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="country"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Work Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="work_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Home Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="home_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Mobile Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" name="mobile_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Email2:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="email" name="email2"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-secondary mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('system_user_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php
		/*
		$user = \App\Models\User::where('id', Request::get('id'))->first();
		
		{{echo $user->email;}}

        $usrDtails = new UserSysDetail;
 
        $usrDtails->user_id = $user->id;
 
        $usrDtails->save();
		*/
	?>
	<script>
		var opsCodeInput = document.getElementById('opsCodeInput'); 			// give an id to your input and set it as variable
		opsCodeInput.value ='Local'; 											// set default value instead of html attribute
		opsCodeInput.onfocus = function() { opsCodeInput.value ='';} 			// on focus - clear input
		//opsCodeInput.onblur = function() { opsCodeInput.value ='Local';} 		// on leave restore it.
		var secLevelInput = document.getElementById('secLevelInput'); 			// give an id to your input and set it as variable
		secLevelInput.value ='Chassis'; 										// set default value instead of html attribute
		secLevelInput.onfocus = function() { secLevelInput.value ='';}			// on focus - clear input
		//secLevelInput.onblur = function() { secLevelInput.value ='Chassis';	// on leave restore it.
		
		var picPath = {!! json_encode($picPath) !!};
		document.getElementById('picture_file').value = picPath;
	</script>
@endsection
