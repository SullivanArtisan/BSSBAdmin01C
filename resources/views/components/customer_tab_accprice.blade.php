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
