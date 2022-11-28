@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">System Users Searched Results (by User Name)</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-secondary mr-4" type="button"><a href="{{route('system_user_add')}}">Add</a></button>
				<!--
				<button class="btn btn-secondary" type="button"">Search</button>
				-->
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="user_search_input">
				  <div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResultById()\" style=\"cursor: pointer;\">by User Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResultByName()\" style=\"cursor: pointer;\">by User Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResultByEmail()\" style=\"cursor: pointer;\">by User Email</button>");</script>
					  <a class="dropdown-item" href="#">Another action</a>
					  <a class="dropdown-item" href="#">Something else here</a>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		use App\Models\UserSysDetail;
		
		$url_components = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url_components['query'], $params);
		$name_parm = $params['name'];
		$users = \App\Models\User::where('name', $name_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$outContents .= "Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Email";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Security Level";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Docket Prefix";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Next Docket #";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Ops Code";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Office";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Default Office";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($users as $user) {
			$userDetails = UserSysDetail::where('user_id', $user->id)->first();
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->email;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->security_level;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->docket_prefix;
					$outContents .= "</a>";
				$outContents .= "</div>";
				if ($userDetails) {
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $user->next_docket_number;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->ops_code;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->current_office;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->default_office;
						$outContents .= "</a>";
					$outContents .= "</div>";
				}
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
	?>
@endsection

<script>
	function GetSearchResultById() {
		user_search_value = document.getElementById('user_search_input').value;
		if (user_search_value) {
			let url = "{{ route('system_user_selected', ':id') }}";
			url = url.replace(':id', 'id='+user_search_value);
			document.location.href=url;
		}
	}
	
	function GetSearchResultByName() {
		user_search_value = document.getElementById('user_search_input').value;
		if (user_search_value) {
			let url = "{{ route('system_user_name_selected', ':name') }}";
			url = url.replace(':name', 'name='+user_search_value);
			document.location.href=url;
		}
	}
	
	function GetSearchResultByEmail() {
		user_search_value = document.getElementById('user_search_input').value;
		if (user_search_value) {
			let url = "{{ route('system_user_email_selected', ':email') }}";
			url = url.replace(':email', 'email='+user_search_value);
			document.location.href=url;
		}
	}
</script>