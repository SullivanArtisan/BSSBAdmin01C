@extends('layouts.home_page2_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
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
		$outContents = "<div class=\"list-group\">";
		$outContents .= "<a href=\"home_page\" class=\"list-group-item list-group-item-action\" aria-current=\"true\">";
		$outContents .= "Item 1";
		$outContents .= "</a>";
		$outContents .= "<a href=\"home_page\" class=\"list-group-item list-group-item-action\">";
		$outContents .= "Item 2";
		$outContents .= "</a>";
		$outContents .= "</div>";
		{{echo $outContents;}}
		
		/*
		foreach ($users as $user) {
			{{ 					
				echo "$user->name<br/>";
			}}
		}
		*/
	?>
@endsection