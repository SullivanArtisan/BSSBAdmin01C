<?php
use App\Helper\MyHelper;
use App\Models\Booking;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('booking_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['selJobId'];
	$ok_to_save = false;
	if ($id) {
		$booking = Booking::where('id', $id)->first();
		// $cstmDispatch = CstmDispatch::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmInvoice = CstmInvoice::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmAllOther = CstmAllOther::where('cstm_account_no', $customer->cstm_account_no)->first();
		if ($booking) {
			if ($booking->bk_status == MyHelper::BkCreatedStaus() || ($booking->bk_status == '0/'.$booking->bk_total_containers.' sent')) {
				$ok_to_save = true;
			}
		}
	}
?>
	
<link rel="stylesheet" href="css/all_tabs_for_customers.css">

@if (!$id or !$booking) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Booking Operation</h2>
				</div>
				<div class="col"></div>
			</div>
		</div>
		
		<div class="alert alert-success m-4">
			<?php
				echo "<span style=\"color:red\">Data cannot NOT be found!</span>";
			?>
		</div>
	@endsection
}
@else {
	@section('function_page')
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<div>
			<div class="row m-4">
				<div>
					<h2 class="text-muted pl-2">Booking: {{$booking->bk_job_no}} (Status: {{$booking->bk_status}} )</h2>
				</div>
				<div class="col-1 my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('booking_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
				</div>
			</div>
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
			<div class="col-md-12 mb-4">
				<form method="post" id="form_booking_old" action="{{route('op_result.booking_update', ['id'=>$id])}}">
					@csrf
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="containerinfo-tab" data-toggle="tab" href="#containerinfo" role="tab" aria-controls="containerinfo" aria-selected="false" onclick="MarkSelectedTab(1)">Container Details</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="bookingdetail-tab" data-toggle="tab" href="#bookingdetail" role="tab" aria-controls="bookingdetail" aria-selected="true" onclick="MarkSelectedTab(2)">Booking Details</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="containerinfo" role="tabpanel" aria-labelledby="containerinfo-tab">
							@include('components.booking_tab_containers')
						</div>

						<div class="tab-pane fade" id="bookingdetail" role="tabpanel" aria-labelledby="bookingdetail-tab">
							@include('components.booking_tab_details')
						</div>
					</div>
					<div class="row my-3">
						<div class="w-25"></div>
						<div class="col">
							<div class="row">
								@if ($ok_to_save == true)
								<button class="btn btn-warning mx-4" type="submit" id="btn_save" onclick="return CheckMatchedZones();">Save</button>
								@else
								<button class="btn btn-dark mx-4" type="submit" id="btn_save" disabled>Save</button>
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
			document.getElementById("btn_save").style.visibility = "hidden";
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this booking job?"))
				event.preventDefault();
			}

			function CheckMatchedZones() {
				var originalPickupZone		= document.getElementById('original_pickup_zone').value;
				var originalDeliveryZone	= document.getElementById('original_delivery_zone').value;
				var inputPickupZone 		= document.getElementById('bk_pickup_cmpny_zone').value;
				var inputDeliveryZone 		= document.getElementById('bk_delivery_cmpny_zone').value;

				if (originalPickupZone != inputPickupZone) {
					if(!confirm("The pickup location's zone doesn't match its pricing zone. Continue?")) {
						event.preventDefault();
					}
				}
				if (originalDeliveryZone != inputDeliveryZone) {
					if(!confirm("The delivery location's zone doesn't match its pricing zone. Continue?")) {
						event.preventDefault();
					}
				}

				// if (document.getElementById("btn_save").innerHTML == 'Previous') {
				// 	event.preventDefault();
				// 	location.reload();
				// }
			}

			function MarkSelectedTab(tab_sel) {
				if (tab_sel == 1) {
					// document.getElementById("btn_save").innerHTML = 'Save';
					document.getElementById("btn_save").style.visibility = "hidden";
				} else {
					// document.getElementById("btn_save").className = 'btn btn-dark mx-4';
					// document.getElementById("btn_save").innerHTML = 'Previous';
					document.getElementById("btn_save").style.visibility = "visible";
				}
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

