@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">System Users</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-secondary mr-4" type="button"><a href="{{route('system_user_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="user_search_input">
				  <div class="input-group-append">
					<button class="btn btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by User Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by User Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by User Email</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		use App\Models\UserSysDetail;
		
		$users = \App\Models\User::paginate(10);
		
		/*
		$outContents = "<ul class=\"list-group\">";
		$outContents .= "<li class=\"list-group-item\">";
		$outContents .= "<input class=\"form-check-input me-1\" type=\"radio\" value=\"\" aria-label=\"...\">";
		$outContents .= "First button";
		$outContents .= "</li>";
		$outContents .= "<li class=\"list-group-item\">";
		$outContents .= "<input class=\"form-check-input me-1\" type=\"radio\" value=\"\" aria-label=\"...\">";
		$outContents .= "Second button";
		$outContents .= "</li>";
		$outContents .= "</ul>";
		*/
		/*
		$outContents = "<div class=\"list-group\">";
		$outContents .= "<a href=\"home_page\" class=\"list-group-item list-group-item-action\" aria-current=\"true\">";
		$outContents .= "Item 1";
		$outContents .= "</a>";
		$outContents .= "<a href=\"home_page\" class=\"list-group-item list-group-item-action\">";
		$outContents .= "Item 2";
		$outContents .= "</a>";
		$outContents .= "</div>";
		{{echo $outContents;}}
		*/
		
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
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $users->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult(search_by) {
		user_search_value = document.getElementById('user_search_input').value;
		if (user_search_value) {
			param = search_by + '=' + user_search_value;
			url = "{{ route('system_user_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>