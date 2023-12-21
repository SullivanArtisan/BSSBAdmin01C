<?php
	$zones = App\Models\Zone::all()->sortBy('zone_name');
	$companies = App\Models\Company::all()->sortBy('cmpny_name');
	$customers = App\Models\Customer::all()->sortBy('cstm_account_no');
	$cstm_names = [];
	$cstm_account_nos = [];
	foreach($customers as $customer) {
		array_push($cstm_names, $customer->cstm_account_name);
		array_push($cstm_account_nos, $customer->cstm_account_no);
	}

	$invoicing_config = MyHelper::$invoiceSendTiming;
	if (!strstr($_SERVER['REQUEST_URI'], 'booking_selected')) {		// User entered this page by clicking the Add button in Bookings
		$page_from_booking_selected = false;
		$booking_id = 0;
		$booking_status = 'deleted';
		$ready_to_be_dispatched_status = '0/? completed';
		$completed_status = '?/? completed';
		$invoice = null;
	} else {	// User entered this page by clicking any existing booking in Bookings
		$page_from_booking_selected = true;
		$booking_id = $booking->id;
		$booking_status = $booking->bk_status;
		$ready_to_be_dispatched_status = '0/'.$booking->bk_total_containers.' '.MyHelper::BkCompletedStaus();
		$completed_status = $booking->bk_total_containers.'/'.$booking->bk_total_containers.' '.MyHelper::BkCompletedStaus();
		$invoice = App\Models\Invoice::where('inv_job_no', $booking->bk_job_no)->first();
	}
	$invoice_existing = 0;
	$invoice_closed   = 0;
	$invoice_cancelled= 0;
	if ($invoice != null) {
		$invoice_existing = 1;
		if ($invoice->inv_status == MyHelper::InvoiceClosedStaus()) {
			$invoice_closed   = 1;
		} else if ($invoice->inv_status == MyHelper::InvoiceCancelledStaus()) {
			$invoice_cancelled   = 1;
		}
	}

?>

<div class="row">
		<div class="col-8">
			<div class="row mb-2">
				<div class="col">
					<div class="card">
          				<div class="card-body">
						  	<div class="row">
								<div class="col-2"><label class="col-form-label">Customer:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!--
									<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_account_name" name="bk_cstm_account_name" value="{{isset($booking)?$booking->bk_cstm_account_name:''}}">
									-->
									<?php
									if (isset($_GET['selJobId'])) {
										$tagHead = "<input readonly list=\"bk_cstm_account_name\" name=\"bk_cstm_account_name\" id=\"bkcstmaccountnameinput\" class=\"form-control mt-1 my-text-height\" ";
									} else {
										$tagHead = "<input list=\"bk_cstm_account_name\" name=\"bk_cstm_account_name\" id=\"bkcstmaccountnameinput\" onchange=\"CstmSelected()\" class=\"form-control mt-1 my-text-height\" ";
									}
										$tagTail = "><datalist id=\"bk_cstm_account_name\">";

									foreach($cstm_names as $cstm_name) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $cstm_name).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_cstm_account_name."\" value=\"".$booking->bk_cstm_account_name."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Billing Account:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!--
									<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_account_no" name="bk_cstm_account_no" value="{{isset($booking)?$booking->bk_cstm_account_no:''}}">
									-->
									<?php
									if (isset($_GET['selJobId'])) {
										$tagHead = "<input readonly list=\"bk_cstm_account_no\" name=\"bk_cstm_account_no\" id=\"bkcstmaccountnoinput\" class=\"form-control mt-1 my-text-height\" ";
									} else {
										$tagHead = "<input list=\"bk_cstm_account_no\" name=\"bk_cstm_account_no\" id=\"bkcstmaccountnoinput\" onchange=\"CstmAccountNoSelected()\" class=\"form-control mt-1 my-text-height\" ";
									}
										$tagTail = "><datalist id=\"bk_cstm_account_no\">";

									foreach($cstm_account_nos as $cstm_cstm_account_no) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $cstm_cstm_account_no).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_cstm_account_no."\" value=\"".$booking->bk_cstm_account_no."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Job Type:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_job_type\" name=\"bk_job_type\" id=\"bkjobtypeinput\" onchange=\"JobTypeSelected()\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_job_type\">";

									$allTypes = MyHelper::GetAllJobTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
								<div class="col-2"><label class="col-form-label">OPS Code:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_ops_code\" name=\"bk_ops_code\" id=\"bkopscodeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_ops_code\">";

									$allTypes = MyHelper::GetAllOpsCodes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_ops_code."\" value=\"".$booking->bk_ops_code."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_ssl_name" name="bk_ssl_name" value="{{isset($booking)?$booking->bk_ssl_name:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">No. of Containers:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_total_containers" name="bk_total_containers" value="{{isset($booking)?$booking->bk_total_containers:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Terminal:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_terminal_name" name="bk_terminal_name" value="{{isset($booking)?$booking->bk_terminal_name:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Gate:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_gate" name="bk_gate" value="{{isset($booking)?$booking->bk_gate:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Vessel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_vessel" name="bk_vessel" value="{{isset($booking)?$booking->bk_vessel:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Voyage:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_voyage" name="bk_voyage" value="{{isset($booking)?$booking->bk_voyage:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">IMO No.:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_imo_no" name="bk_imo_no" value="{{isset($booking)?$booking->bk_imo_no:''}}">
								</div>
								<div class="col-1"><label class="col-form-label">&nbsp;</label></div>
								@if (true == $page_from_booking_selected)
								<div class="col-2"><button class="btn btn-success mt-1" onclick="return SendInvoice();">Send Invoice</button></div>
								<div class="col-3"><button class="btn btn-danger mt-1" onclick="return PayOffThisBooking();">Pay Off This Booking</button></div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="card">
          				<div class="card-body">
						  	<div class="row">
							  	<div class="col text-center"><label class="col-form-label font-weight-bold">Pickup Address:&nbsp;</label></div>
							  	<div class="col text-center"><i class="bi bi-chevron-double-left"></i><i class="bi bi-three-dots"></i><i class="bi bi-chevron-double-right"></i></div>
								<div class="col text-center"><label class="col-form-label font-weight-bold">Delivery Address:&nbsp;</label></div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Company:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_name" name="bk_pickup_cmpny_name" value="{{isset($booking)?$booking->bk_pickup_cmpny_name:''}}"> -->
									<input list="bk_pickup_cmpny_name_li" name="bk_pickup_cmpny_name" id="bk_pickup_cmpny_name" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_pickup_cmpny_name:''}}">
									<datalist id="bk_pickup_cmpny_name_li">
									<?php
										foreach ($companies as $company) {
											echo "<option value=\"".$company->cmpny_name."\">";
										}
									?>
									</datalist></input>
									<input type="hidden" id="original_pickup_zone" name="original_pickup_zone" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Company:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_name" name="bk_delivery_cmpny_name" value="{{isset($booking)?$booking->bk_delivery_cmpny_name:''}}"> -->
									<input list="bk_delivery_cmpny_name_li" name="bk_delivery_cmpny_name" id="bk_delivery_cmpny_name" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_delivery_cmpny_name:''}}">
									<datalist id="bk_delivery_cmpny_name_li">
									<?php
										foreach ($companies as $company) {
											echo "<option value=\"".$company->cmpny_name."\">";
										}
									?>
									</datalist></input>
									<input type="hidden" id="original_delivery_zone" name="original_delivery_zone" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_1" name="bk_pickup_cmpny_addr_1" value="{{isset($booking)?$booking->bk_pickup_cmpny_addr_1:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_1" name="bk_delivery_cmpny_addr_1" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_1:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_2" name="bk_pickup_cmpny_addr_2" value="{{isset($booking)?$booking->bk_pickup_cmpny_addr_2:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_2" name="bk_delivery_cmpny_addr_2" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_2:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_3" name="bk_pickup_cmpny_addr_3" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_3:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_3" name="bk_delivery_cmpny_addr_3" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_3:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_city" name="bk_pickup_cmpny_city" value="{{isset($booking)?$booking->bk_pickup_cmpny_city:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_city" name="bk_delivery_cmpny_city" value="{{isset($booking)?$booking->bk_delivery_cmpny_city:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_province" name="bk_pickup_cmpny_province" value="{{isset($booking)?$booking->bk_pickup_cmpny_province:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_province" name="bk_delivery_cmpny_province" value="{{isset($booking)?$booking->bk_delivery_cmpny_province:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_postcode" name="bk_pickup_cmpny_postcode" value="{{isset($booking)?$booking->bk_pickup_cmpny_postcode:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_postcode" name="bk_delivery_cmpny_postcode" value="{{isset($booking)?$booking->bk_delivery_cmpny_postcode:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_country" name="bk_pickup_cmpny_country" value="{{isset($booking)?$booking->bk_pickup_cmpny_country:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_country" name="bk_delivery_cmpny_country" value="{{isset($booking)?$booking->bk_delivery_cmpny_country:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_pickup_movement_type\" name=\"bk_pickup_movement_type\" id=\"bkpickupmovementtypeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_pickup_movement_type\">";

									$allTypes = MyHelper::GetCommonMovementTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_pickup_movement_type."\" value=\"".$booking->bk_pickup_movement_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_delivery_movement_type\" name=\"bk_delivery_movement_type\" id=\"bkdeliverymovementtypeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_delivery_movement_type\">";

									$allTypes = MyHelper::GetCommonMovementTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_delivery_movement_type."\" value=\"".$booking->bk_delivery_movement_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_contact" name="bk_pickup_cmpny_contact" value="{{isset($booking)?$booking->bk_pickup_cmpny_contact:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_contact" name="bk_delivery_cmpny_contact" value="{{isset($booking)?$booking->bk_delivery_cmpny_contact:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_tel" name="bk_pickup_cmpny_tel" value="{{isset($booking)?$booking->bk_pickup_cmpny_tel:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_tel" name="bk_delivery_cmpny_tel" value="{{isset($booking)?$booking->bk_delivery_cmpny_tel:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_email" name="bk_pickup_cmpny_email" value="{{isset($booking)?$booking->bk_pickup_cmpny_email:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_email" name="bk_delivery_cmpny_email" value="{{isset($booking)?$booking->bk_delivery_cmpny_email:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_remarks" name="bk_pickup_remarks" value="{{isset($booking)?$booking->bk_pickup_remarks:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_remarks" name="bk_delivery_remarks" value="{{isset($booking)?$booking->bk_delivery_remarks:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_zone" name="bk_pickup_cmpny_zone" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}"> -->
									<input list="bk_pickup_cmpny_zone_li" name="bk_pickup_cmpny_zone" id="bk_pickup_cmpny_zone" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}">
									<datalist id="bk_pickup_cmpny_zone_li">
									<?php
										foreach ($zones as $zone) {
											echo "<option value=\"".$zone->zone_name."\">";
										}
									?>
									</datalist></input>
								</div>
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_zone" name="bk_delivery_cmpny_zone" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}"> -->
									<input list="bk_delivery_cmpny_zone_li" name="bk_delivery_cmpny_zone" id="bk_delivery_cmpny_zone" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}">
									<datalist id="bk_delivery_cmpny_zone_li">
									<?php
										foreach ($zones as $zone) {
											echo "<option value=\"".$zone->zone_name."\">";
										}
									?>
									</datalist></input>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="card">
          		<div class="card-body">
				  	<div class="row">
						<div class="col-4"><label class="col-form-label">Booked By:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_name" name="bk_booker_name" value="{{isset($booking)?$booking->bk_booker_name:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Tel:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_tel" name="bk_booker_tel" value="{{isset($booking)?$booking->bk_booker_tel:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Email:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_email" name="bk_booker_email" value="{{isset($booking)?$booking->bk_booker_email:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Customer Order #:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_order_no" name="bk_cstm_order_no" value="{{isset($booking)?$booking->bk_cstm_order_no:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booking #:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booking_no" name="bk_booking_no" value="{{isset($booking)?$booking->bk_booking_no:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_goods_desc" name="bk_goods_desc" value="{{isset($booking)?$booking->bk_goods_desc:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_goods_desc" name="bk_goods_desc" value="{{isset($booking)?$booking->bk_goods_desc:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
						<div class="col-4">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_cargo_weight" name="bk_cargo_weight" value="{{isset($booking)?$booking->bk_cargo_weight:''}}">
						</div>
						<div class="col-4">
							<?php
							$tagHead = "<input list=\"bk_weight_unit\" name=\"bk_weight_unit\" id=\"bkweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
							$tagTail = "><datalist id=\"bk_weight_unit\">";
							$tagTail.= "<option value=\"Kgs\">";
							$tagTail.= "<option value=\"Lbs\">";
							$tagTail.= "</datalist>";
							if (isset($_GET['selJobId'])) {
								echo $tagHead."placeholder=\"".$booking->bk_weight_unit."\" value=\"".$booking->bk_weight_unit."\"".$tagTail;
							} else {
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							}
					?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Invoice Group Number:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_invoice_group_no" name="bk_invoice_group_no" value="{{isset($booking)?$booking->bk_invoice_group_no:''}}">
						</div>
					</div>
				</div>
			</div>
			<div class="card mt-2">
          		<div class="card-body">
				  	<div class="row ml-1">
						<div><label class="col-form-label">Internal Notes:&nbsp;</label></div>
					</div>
					<div class="row">
						<div class="col-12">
							<textarea class="form-control mt-1 my-text-height" id="bk_internal_notes" name="bk_internal_notes" value="{{isset($booking)?$booking->bk_internal_notes:''}}"></textarea>
						</div>
					</div>
					<div class="row ml-1 mt-1">
						<div><label class="col-form-label">Driver's Notes:&nbsp(Goes to PDA on each leg of job)</label></div>
					</div>
					<div class="row">
						<div class="col-12">
							<textarea class="form-control mt-1 my-text-height" id="bk_driver_notes" name="bk_driver_notes" value="{{isset($booking)?$booking->bk_driver_notes:''}}"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function CstmSelected() {
			var cstmNames = {!!json_encode($cstm_names) !!};
			var cstmAccountNos = {!!json_encode($cstm_account_nos) !!};
			selCstm = document.getElementById("bkcstmaccountnameinput").value.normalize('NFKD');
			for(let idx=0; idx<cstmNames.length; idx++) {
				if (selCstm == cstmNames[idx]) {
					document.getElementById("bkcstmaccountnoinput").value = cstmAccountNos[idx];
				}
			}
		}

		function CstmAccountNoSelected() {
			var cstmNames = {!!json_encode($cstm_names) !!};
			var cstmAccountNos = {!!json_encode($cstm_account_nos) !!};
			selCstmAccountNo = document.getElementById("bkcstmaccountnoinput").value.normalize('NFKD');
			for(let idx=0; idx<cstmAccountNos.length; idx++) {
				if (selCstmAccountNo == cstmAccountNos[idx]) {
					document.getElementById("bkcstmaccountnameinput").value = cstmNames[idx];
				}
			}
		}

		function JobTypeSelected() {
			selType = document.getElementById("bkjobtypeinput").value.normalize('NFKD');
			if (selType == {!! json_encode(MyHelper::$allJobTypes[0]) !!} ) {	
				// User selected "Import" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[4]) !!};		// Set pickup movement type to "Port Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[7]) !!};		// Set delivery movement type to "Customer Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[1]) !!} ) {	
				// User selected "Export" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[6]) !!};		// Set pickup movement type to "Customer Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[5]) !!};		// Set delivery movement type to "Port Drop"
			} else if (selType == {!! json_encode( MyHelper::$allJobTypes[2]) !!} ) {	
				// User selected "Empty Repo" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[0]) !!};		// Set pickup movement type to "Container Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[1]) !!};		// Set delivery movement type to "Container Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[3]) !!} ) {	
				// User selected "Yard Move" job type
				document.getElementById("bkpickupmovementtypeinput").value = "";
				document.getElementById("bkdeliverymovementtypeinput").value = "";
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[4]) !!} ) {	
				// User selected "Other" job type
				document.getElementById("bkpickupmovementtypeinput").value = ""; 	// {!! json_encode(MyHelper::$allMovementTypes[6]) !!};		// Set pickup movement type to "Customer Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = "";	// {!! json_encode(MyHelper::$allMovementTypes[5]) !!};		// Set delivery movement type to "Port Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[5]) !!} ) {	
				// User selected "CBSA" job type
				document.getElementById("bkpickupmovementtypeinput").value = "";
				document.getElementById("bkdeliverymovementtypeinput").value = "";
			} else {
			}
		}

		bookId = {!! json_encode($booking_id) !!};
		bookStatus = {!! json_encode($booking_status) !!};
		invoicingConfig = {!! json_encode($invoicing_config) !!};
		readyToBeDispatchedStatus = {!! json_encode($ready_to_be_dispatched_status) !!};
		completedStatus = {!! json_encode($completed_status) !!};
		invoiceExisting = {!! json_encode($invoice_existing) !!};
		invoiceClosed   = {!! json_encode($invoice_closed) !!};
		invoiceCancelled= {!! json_encode($invoice_cancelled) !!};

		function PayOffThisBooking() {
			event.preventDefault();
			var token = "{{ csrf_token() }}";

			if (bookStatus != completedStatus) {
				alert("You cannot pay off this booking now.");
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

		function SendInvoice() {
			event.preventDefault();

			if (invoicingConfig == 'all_containers_completed') {
				if (bookStatus != completedStatus) {
					alert("\r\nSorry!!\r\nYou cannot send this booking's invoice to the customer now.");
					return;
				}
			} else {	// Default config: all_containers_ready_to_be_dispatched
				if (bookStatus != readyToBeDispatchedStatus) {
					alert("\r\nSorry!!\r\nYou cannot send this booking's invoice to the customer now.");
					return;
				}
			}

			if (invoiceExisting == 1 && invoiceClosed == 1) {
				alert("\r\nOops!!\r\nYou cannot send this booking's invoice again.");
			} else {
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
	</script>
