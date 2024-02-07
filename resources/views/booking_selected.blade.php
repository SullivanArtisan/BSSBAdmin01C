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
	$status_all_dispatched = '0/? completed';
	$invoicing_config = MyHelper::$invoiceSendTiming;
	$invoice_existing 	= 0;
	$invoice_closed 	= 0;
	$invoice_cancelled	= 0;
	$can_delete_booking = 1;
	$bk_total_containers= 0;
	if ($id) {
		$booking = Booking::where('id', $id)->first();
		// $cstmDispatch = CstmDispatch::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmInvoice = CstmInvoice::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmAllOther = CstmAllOther::where('cstm_account_no', $customer->cstm_account_no)->first();
		if ($booking) {
			$bk_total_containers = $booking->bk_total_containers;
			if ($booking->bk_status == MyHelper::BkCreatedStaus() || ($booking->bk_status == '0/'.$booking->bk_total_containers.' '.MyHelper::BkSentStaus())) {
				$ok_to_save = true;
			}
			if (strstr($booking->bk_status, MyHelper::BkCompletedStaus()) || $booking->bk_status == MyHelper::BkInvoicedStaus() || $booking->bk_status == MyHelper::BkFullyPaidStaus() || $booking->bk_status == MyHelper::BkPartialyPaidStaus()) {
				$can_delete_booking = 0;
			}
			$status_all_dispatched = '0/'.$booking->bk_total_containers.' '.MyHelper::BkCompletedStaus();
			$invoice = App\Models\Invoice::where('inv_job_no', $booking->bk_job_no)->first();
			if ($invoice != null) {
				$invoice_existing = 1;
				if ($invoice->inv_status == MyHelper::InvoiceClosedStaus()) {
					$invoice_closed   = 1;
				} else if ($invoice->inv_status == MyHelper::InvoiceCancelledStaus()) {
					$invoice_cancelled   = 1;
				}
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
				<div class="col-1 my-auto">
					<button class="btn btn-success mt-1" onclick="return SendInvoice();">Send Invoice</button>
				</div>
				<div class="col-3 my-auto ml-2">
					@if ($booking && $booking->bk_status != MyHelper::BkFullyPaidStaus())
					<button class="btn btn-warning mt-1" onclick="return PayOffThisBooking();">Pay Off This Booking</button>
					@else
					<button class="btn btn-info mt-1" data-toggle="modal" data-target="#exampleModal">View Invoice</button>
					@endif
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

		<?php
			$inv_file_name = $booking->bk_inv_serial_no.'.pdf';
		?>
		<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Booking {{$booking->bk_job_no}}'s Invoice</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="PDF">
						<object data={{$inv_file_name}} type="application/pdf" width="750" height="600">
						</object>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
				</div>
			</div>
		</div>

		<script>
			document.getElementById("btn_save").style.visibility = "hidden";
		</script>
		
		<script>
			function myConfirmation() {
				let canDeleteBooking  = {!! json_encode($can_delete_booking) !!};
				let bkTotalContainers = {!! json_encode($bk_total_containers) !!};

				if (1 == canDeleteBooking) {
					if (0 < bkTotalContainers) {
						event.preventDefault();
						alert("Please remove all the joined containers of this booking before you delete it!");
					} else {
						if(!confirm("Are you sure to delete this booking job?"))
							event.preventDefault();
					}
				} else {
					event.preventDefault();
					alert("\r\nSorry!!\r\nThis booking cannot be deleted now.");
				}
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


			invoicingConfig = {!! json_encode($invoicing_config) !!};
			bookId = {!! json_encode($booking->id) !!};
			bookStatus = {!! json_encode($booking->bk_status) !!};
			statusCompleted = {!! json_encode($booking->bk_total_containers.'/'.$booking->bk_total_containers.' '.MyHelper::BkCompletedStaus()) !!};
			statusInvoiced = {!! json_encode(MyHelper::BkInvoicedStaus()) !!};
			statusAllDispatched = {!! json_encode($status_all_dispatched) !!};
			invoiceExisting = {!! json_encode($invoice_existing) !!};
			invoiceCancelled = {!! json_encode($invoice_cancelled) !!};
			invoiceClosed 	 = {!! json_encode($invoice_closed) !!};

			function SendInvoice() {
				event.preventDefault();

				if (invoicingConfig == 'all_containers_completed') {	// Default config : all_containers_completed
					if (bookStatus != statusCompleted && bookStatus != statusInvoiced) {
						alert("\r\nSorry!!\r\nYou cannot send this booking's invoice to the customer now.");
						return;
					}
				} else {	// all_containers_dispatched
					if (bookStatus != statusAllDispatched && bookStatus != statusInvoiced) {
						alert("\r\nSorry!!\r\nYou cannot send this booking's invoice to the customer now.");
						return;
					}
				}

				let sendIt = false;
				if (invoiceExisting == 1) {
					if (invoiceCancelled == 1 || invoiceClosed == 1) {
						alert("\r\nOops!!\r\nYou cannot send this booking's invoice again.");
					} else {
						if(confirm("The invoice has been sent before. Do you want to send it again?")) {
							sendIt = true;
						}
					}
				} else {
					sendIt = true;
				}

				if (sendIt) {
					var token = "{{ csrf_token() }}";
					$.ajax({
						url: '/send_invoice_to_customer',
						type: 'POST',
						data: {_token:token, booking_id:bookId},    // the _token:token is for Laravel
						success: function(dataRetFromPHP) {
							location.href = location.href;
							alert("The invoice of this booking has been sent to the customer successfully!");
						},
						error: function(err) {
							console.log(err);
							alert(err);
						}
					});
				}
			}

			function PayOffThisBooking() {
				event.preventDefault();
				var token = "{{ csrf_token() }}";

				if (bookStatus != statusInvoiced) {
					alert("\r\nSorry!!\r\nYou cannot pay off this booking now.");
				} else {
					$.ajax({
						url: '/booking_pay_off',
						type: 'POST',
						data: {_token:token, booking_id:bookId},    // the _token:token is for Laravel
						success: function(dataRetFromPHP) {
							location.href = location.href;
							alert("This booking is paid off successfully!");
						},
						error: function(err) {
							console.log(err);
							alert(err);
						}
					});
				}
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

