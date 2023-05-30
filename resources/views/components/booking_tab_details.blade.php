	<div class="row">
		<div class="col-8">
			<div class="row mb-2">
				<div class="col">
					<div class="card">
          				<div class="card-body">
						  	<div class="row">
								<div class="col-2"><label class="col-form-label">Billing Account:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_cstm_account_no\" name=\"bk_cstm_account_no\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Customer:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_cstm_account_name\" name=\"bk_cstm_account_name\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Job Type:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_job_type\" name=\"bk_job_type\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">OPS Code:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_ops_code\" name=\"bk_ops_code\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_ssl_name\" name=\"bk_ssl_name\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">No. of Containers:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_total_containers\" name=\"bk_total_containers\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Terminal:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_terminal_name\" name=\"bk_terminal_name\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Gate:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_gate\" name=\"bk_gate\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Vessel:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_vessel\" name=\"bk_vessel\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Voyage:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_voyage\" name=\"bk_voyage\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">IMO No.:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_imo_no\" name=\"bk_imo_no\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
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
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_name\" name=\"bk_pickup_cmpny_name\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Company:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_name\" name=\"bk_delivery_cmpny_name\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_addr_1\" name=\"bk_pickup_cmpny_addr_1\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_addr_1\" name=\"bk_delivery_cmpny_addr_1\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_addr_2\" name=\"bk_pickup_cmpny_addr_2\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_addr_2\" name=\"bk_delivery_cmpny_addr_2\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_addr_3\" name=\"bk_pickup_cmpny_addr_3\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_addr_3\" name=\"bk_delivery_cmpny_addr_3\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_city\" name=\"bk_pickup_cmpny_city\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_city\" name=\"bk_delivery_cmpny_city\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_province\" name=\"bk_pickup_cmpny_province\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_province\" name=\"bk_delivery_cmpny_province\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_postcode\" name=\"bk_pickup_cmpny_postcode\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_postcode\" name=\"bk_delivery_cmpny_postcode\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_country\" name=\"bk_pickup_cmpny_country\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_country\" name=\"bk_delivery_cmpny_country\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_movement_type\" name=\"bk_pickup_movement_type\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_movement_type\" name=\"bk_delivery_movement_type\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_contact\" name=\"bk_pickup_cmpny_contact\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_contact\" name=\"bk_delivery_cmpny_contact\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_tel\" name=\"bk_pickup_cmpny_tel\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_tel\" name=\"bk_delivery_cmpny_tel\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_email\" name=\"bk_pickup_cmpny_email\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_email\" name=\"bk_delivery_cmpny_email\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_remarks\" name=\"bk_pickup_remarks\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_remarks\" name=\"bk_delivery_remarks\">";
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_pickup_cmpny_zone\" name=\"bk_pickup_cmpny_zone\">";
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<?php
									echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_delivery_cmpny_zone\" name=\"bk_delivery_cmpny_zone\">";
									?>
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
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_booker_name\" name=\"bk_booker_name\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Tel:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_booker_tel\" name=\"bk_booker_tel\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Email:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_booker_email\" name=\"bk_booker_email\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Customer Order #:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_cstm_order_no\" name=\"bk_cstm_order_no\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booking #:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_booking_no\" name=\"bk_booking_no\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_goods_desc\" name=\"bk_goods_desc\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_goods_desc\" name=\"bk_goods_desc\">";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
						<div class="col-4">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_cargo_weight\" name=\"bk_cargo_weight\">";
							?>
						</div>
						<div class="col-4">
							<?php
							$tagHead = "<input list=\"bk_weight_unit\" name=\"bk_weight_unit\" id=\"bkweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
							$tagTail = "><datalist id=\"bk_weight_unit\">";
							$tagTail.= "<option value=\"Kgs\">";
							$tagTail.= "<option value=\"Lbs\">";
							$tagTail.= "</datalist>";
							echo $tagHead."placeholder=\"Kgs\" value=\"Kgs\"".$tagTail;
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Invoice Group Number:&nbsp;</label></div>
						<div class="col-8">
							<?php
							echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"bk_invoice_group_no\" name=\"bk_invoice_group_no\">";
							?>
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
							<?php
							echo "<textarea class=\"form-control mt-1 my-text-height\" id=\"bk_internal_notes\" name=\"bk_internal_notes\"></textarea>";
							?>
						</div>
					</div>
					<div class="row ml-1 mt-1">
						<div><label class="col-form-label">Driver's Notes:&nbsp(Goes to PDA on each leg of job);</label></div>
					</div>
					<div class="row">
						<div class="col-12">
							<?php
							echo "<textarea class=\"form-control mt-1 my-text-height\" id=\"bk_driver_notes\" name=\"bk_driver_notes\"></textarea>";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
