<?php
	use App\Models\UserSysDetail;
?>

@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('system_user_main')}}" style="margin-right: 10px;">Back</a>
@show


@section('function_page')
	<div>
		<h2 class="text-muted pl-2">System Users</h2>
	</div>
	<?php
	
		$user = \App\Models\User::where('id', Request::get('id'))->first();
		
		{{echo $user->email;}}
	?>
@endsection
