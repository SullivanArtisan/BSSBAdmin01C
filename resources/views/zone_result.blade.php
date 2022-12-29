@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('zone_main')}}" style="margin-right: 10px;">Back</a>
@show


@section('function_page')
    <div>
        <div class="row">
            <div class="col col-sm-auto">
				<h2 class="text-muted pl-2">Result of the Zone Operation</h2>
            </div>
            <div class="col"></div>
        </div>
    </div>
	
	@if(session('status'))
	<div class="alert alert-success">
		<?php
			$text = session('status');
			echo $text;
		?>
	</div>
	@endif
@endsection
