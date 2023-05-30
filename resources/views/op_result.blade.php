@extends('layouts.home_page_base')

@section('goback')
	<?php
		if ($oprand == "unit") {		// This is a special case for power_unit_main as there are 2 words: power and unit. I don't want to change file names for consistance reason.
			$backPath = '<a class="text-primary" href="'.route('power_unit_main').'" style="margin-right: 10px;">Back</a>';
		} else if ($oprand == "user") {	// This is another special case for system_user_main as there are 2 words: system and user. I don't want to change file names for consistance reason.
			$backPath = '<a class="text-primary" href="'.route('system_user_main').'" style="margin-right: 10px;">Back</a>';
		} else if ($oprand == "container") {	// This is another special case for container_main as the container_main not exists; I have to go to the special URL
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
			} else {
				$id = session('id');
			}
			$backPath = '<a class="text-primary" href="'.route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$id]).'" style="margin-right: 10px;">Back</a>';
		} else {
			$tmpPath = $oprand.'_main';
			$backPath = '<a class="text-primary" href="'.route($tmpPath).'" style="margin-right: 10px;">Back</a>';
		}
		echo $backPath;
	?>
@show


@section('function_page')
    <div>
        <div class="row">
            <div class="col col-sm-auto">
				<h2 class="text-muted pl-2">Result of the <?php echo ucfirst($oprand) ?> Operation</h2>
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
