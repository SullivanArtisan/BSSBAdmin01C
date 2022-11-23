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
				<button class="btn btn-secondary me-2" type="button"><a href="{{route('system_user_add')}}">Add</a></button>
				<button class="btn btn-secondary" type="button">Search</button>
			</div>
            <div class="col"></div>
        </div>
    </div>
	<?php
		$users = \App\Models\User::all();
		
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
		
		$outContents = "<div class=\"list-group\">";
		{{echo $outContents;}}
		foreach ($users as $user) {
			$outContents = "<a href=\"system_user_selected?id=$user->id\" class=\"list-group-item list-group-item-action\" aria-current=\"true\">";
			$outContents .= $user->name;
			$outContents .= "</a>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
	?>
@endsection
