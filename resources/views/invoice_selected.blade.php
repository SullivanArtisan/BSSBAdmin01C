<?php
use App\Helper\MyHelper;
use App\Models\Invoice;
use App\Models\Booking;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('invoice_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['selInvId'];
	if ($id) {
		$invoice = Invoice::where('id', $id)->first();
		$booking = Booking::where('bk_job_no', $invoice->inv_job_no)->first();
	}
?>
	
<link rel="stylesheet" href="css/all_tabs_for_customers.css">

@if (!$id or !$invoice) {
	@section('function_page')
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
					<h2 class="text-muted pl-2">Invoice of Booking: <span class="text-primary">{{$invoice->inv_job_no}}</span> (for customer: <span class="text-primary">{{$booking->bk_cstm_account_name}}</span>)</h2>
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
            <?php
                $inv_file_name = $invoice->inv_serial_no.'.pdf';
            ?>
			<div class="col-md-12 mb-4">
					<div class="row my-3">
						<div class="w-25"></div>
						<div class="col">
							<div class="row">
                                <div class="col">
                                    <div class="PDF">
                                        <object data={{$inv_file_name}} type="application/pdf" width="750" height="600">
                                        </object>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="col"></div>
					</div>
			</div>
		</div>

		<script>
		</script>
	@endsection
}
@endif

	<?php
	?>

