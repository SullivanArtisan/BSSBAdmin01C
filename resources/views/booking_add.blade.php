<?php
	use App\Models\Driver;
    ?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('booking_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div>
		<?php
		if (isset($_GET['bookingResult'])) {
			$booking_result = $_GET['bookingResult'];
		} else {
			$booking_result = '';
		}
		?>
		<div class="row"><div class="col-3"><h2 class="text-muted pl-2 mb-2">Enter a New Job</h2></div><div class="col-9 mt-2"><?php echo $booking_result;?></div></div>
	</div>
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
    <link rel="stylesheet" href="css/all_tabs_for_customers.css">

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

		<?php
			if (isset($_GET['bookingTab'])) {
				$booking_tab = $_GET['bookingTab'];
			} else {
				$booking_tab = '';
			}

			if (isset($_GET['id'])) {
				$id = $_GET['id'];
			} else {
				$id = '';
			}
		?>

		<div class="col-md-12 mb-4">
			<form method="post" id="form_booking_old" action="{{route('op_result.booking_add')}}">
				@csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
						@if ($booking_tab == '')
                        <a class="nav-link active " id="bookingdetail-tab" data-toggle="tab" href="#bookingdetail" role="tab" aria-controls="bookingdetail" aria-selected="true">Booking Details</a>
						@else
                        <a class="nav-link" id="bookingdetail-tab" data-toggle="tab" href="#bookingdetail" role="tab" aria-controls="bookingdetail" aria-selected="false">Booking Details</a>
						@endif
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
					@if ($booking_tab == '')
                    <div class="tab-pane fade show active" id="bookingdetail" role="tabpanel" aria-labelledby="bookingdetail-tab">
					@else
                    <div class="tab-pane fade" id="bookingdetail" role="tabpanel" aria-labelledby="bookingdetail-tab">
					@endif
                        @include('components.booking_tab_details')
                    </div>
                </div>
				<div class="row my-3">
					<div class="w-25"></div>
					<div class="col">
						<div class="row">
							@if ($id == '' && $booking_tab == "")
							<button class="btn btn-success mx-4" type="submit">Add</button>
							@else
							<a href="{{route('home_page');}}"><button class="btn btn-success mx-4" type="button">Return</button></a>
							@endif
							<!--
							<button class="btn btn-secondary mx-3" type="button"><a href="{{route('home_page')}}">Cancel</a></button>
							-->
						</div>
					</div>
					<div class="col"></div>
				</div>
			</form>
		</div>
    </div>

	<script>

	</script>	
	<!--
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	-->
@endsection
