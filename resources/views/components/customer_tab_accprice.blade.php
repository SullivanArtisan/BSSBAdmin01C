<?php
	use App\Models\Customer;
	use App\Models\CstmAccountPrice;
	use App\Models\Zone;
	
	$zones = Zone::all()->sortBy('zone_name');
?>

	<div class="row">
		<div class="col">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li>
					<a class="nav-link active " id="t1-tab" data-toggle="tab" href="#t1" role="tab" aria-controls="contact" aria-selected="true">View Prices</a>
				</li>
				<li>
					<a class="nav-link" id="t2-tab" data-toggle="tab" href="#t2" role="tab" aria-controls="dispatch" aria-selected="false">Add New Price</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="t1" role="tabpanel" aria-labelledby="t1-tab">
					<table class="table table-striped table-sm table-bordered">
						<thead style="background: var(--bs-teal);">
							<tr>
								<th>Chassis</th>
								<th>From</th>
								<th>To</th>
								<th>Charge</th>
								<th>Job Type</th>
								<th>One Way</th>
								<th>MT Return</th>
							</tr>
						</thead>
						<tbody class="table-group-divider">
							<?php
								$id = $_GET['id'];
								if ($id) {
									$customer = Customer::where('id', $id)->first();
									$cstmPrices = CstmAccountPrice::where('cstm_account_no', $customer->cstm_account_no)->get();								
									foreach ($cstmPrices as $cstmPrice) {
										echo "<tr>";
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_chassis."</a></td>";
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_from."</a></td>";
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_to."</td>";
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_charge."</td>";
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_job_type."</td>";
										if ($cstmPrice->cstm_account_one_way) {
											echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">T</td>";
										} else {
											echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">F</td>";
										}
										echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_mt_return."</td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="t2" role="tabpanel" aria-labelledby="t2-tab">
					<form method="post" action="{{route('customer_accprice_add')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Zone From:&nbsp;</label></div>
							<div class="col">
								<input list="cstm_account_from" name="cstm_account_from" id="cstm_account_from_li" class="form-control mt-1 my-text-height">
								<datalist id="cstm_account_from">
								<?php
									foreach ($zones as $zone) {
										echo "<option value=\"".$zone->zone_name."\">";
									}
								?>
								</datalist></input></div>
							<div class="col"><label class="col-form-label">Zone To:&nbsp;</label></div>
							<div class="col">
								<input list="cstm_account_to" name="cstm_account_to" id="cstm_account_to_li" class="form-control mt-1 my-text-height">
								<datalist id="cstm_account_to">
								<?php
									foreach ($zones as $zone) {
										echo "<option value=\"".$zone->zone_name."\">";
									}
								?>
								</datalist></input></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Chassis (or Blank):&nbsp;</label></div>
							<div class="col">
								<input list="cstm_account_chassis" name="cstm_account_chassis" id="cstm_account_chassis_li" class="form-control mt-1 my-text-height">
									<datalist id="cstm_account_chassis">
										<option value="12PT">
										<option value="AIRRIDE">
										<option value="BTRAIN">
										<option value="DOUBLE DROP DECK">
										<option value="STEP DECK">
										<option value="SUPER">
										<option value="TANDEM">
										<option value="TRAILER">
										<option value="TRIAXLE">
										<option value="TTRAIN">
									</datalist></div>
							<div class="col"><label class="col-form-label">Job Type:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_job_type" name="cstm_account_job_type"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Empty Location:&nbsp;</label></div>
							<div class="col">
								<input list="cstm_account_mt_return" name="cstm_account_mt_return" id="cstm_account_mt_return_li" class="form-control mt-1 my-text-height">
									<datalist id="cstm_account_mt_return">
										<option value="Empty Location 1">
										<option value="Empty Location 2">
										<option value="Empty Location 3">
										<option value="Empty Location 4">
										<option value="Empty Location 5">
										<option value="Empty Location 6">
										<option value="Empty Location 7">
										<option value="Empty Location 8">
										<option value="Empty Location 9">
										<option value="Empty Location 10">
									</datalist></div>
							<div class="col"><label class="col-form-label">Account Charge:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_charge" name="cstm_account_charge"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Fuel Surcharge:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_fuel_surcharge" name="cstm_account_fuel_surcharge"></div>
							<div class="col"><label class="col-form-label">Override:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_surcharge_override" name="cstm_account_surcharge_override"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">One Way:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_one_way" name="cstm_account_one_waycstm_account_one_way"></div>
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn mx-4" style="background-image: linear-gradient(to top, #286aad  25%, #43cea2  100%); color: #FFF;" type="submit">Add</button>
									<button class="btn mx-3" style="background-image: linear-gradient(to top, #286aad  25%, #43cea2  100%); color: #FFF;" type="button" id="btn_accprice_cancel"><a href="#">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		var btnAccPriceCancel = document.getElementById('btn_accprice_cancel'); 
		btnAccPriceCancel.onclick = function() { 
			this.form.elements["cstm_account_from"].value  = "";
			this.form.elements["cstm_account_to"].value  = "";
			this.form.elements["cstm_account_chassis"].value  = "";
			cstm_account_job_type.value ='';
			this.form.elements["cstm_account_mt_return"].value  = "";
			cstm_account_charge.value = 0;
			cstm_account_fuel_surcharge.value = 0;
			cstm_account_surcharge_override.checked=false;
			cstm_account_one_way.checked=false;
		} 

		var tabPrice1 = document.getElementById('t1-tab'); 
		var tabPrice2 = document.getElementById('t2-tab'); 
		var tabCtnts1 = document.getElementById('t1'); 
		var tabCtnts2 = document.getElementById('t2'); 
		tabPrice1.style.backgroundColor = "#FAF5EF";
		tabCtnts1.style.backgroundColor = "#FAF5EF";
		tabCtnts1.style.border = "1px solid #FAF5EF";
		tabCtnts2.style.backgroundColor = "#FAF5EF";
		tabCtnts2.style.border = "1px solid #FAF5EF";
		tabPrice1.onclick = function() { 
			tabPrice1.style.backgroundColor = "#FAF5EF";
			tabPrice2.style.backgroundColor = "#FFF";
		} 
		tabPrice2.onclick = function() { 
			tabPrice2.style.backgroundColor = "#FAF5EF";
			tabPrice1.style.backgroundColor = "#FFF";
		} 
	</script>
