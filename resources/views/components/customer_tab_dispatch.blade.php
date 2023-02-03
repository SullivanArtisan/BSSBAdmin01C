	<div class="row">
		<div class="col"><label class="col-form-label">POD Email 1:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_dspch_pod_email1\" name=\"cstm_dspch_pod_email1\" value=\"".$dbTable->cstm_dspch_pod_email1."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_dspch_pod_email1\" name=\"cstm_dspch_pod_email1\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Customer Group 1:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_group1" name="cstm_dspch_group1"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">POD Email 2:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_pod_email2" name="cstm_dspch_pod_email2"></div>
		<div class="col"><label class="col-form-label">Customer Group 2:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_group2" name="cstm_dspch_group2"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Force Reference:&nbsp;</label></div>
		<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_dspch_force_ref" name="cstm_dspch_force_ref"></div>
		<div class="col"><label class="col-form-label">Customer Group 3:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_group3" name="cstm_dspch_group3"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Email POD:&nbsp;</label></div>
		<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_dspch_email_pod" name="cstm_dspch_email_pod"></div>
		<div class="col"><label class="col-form-label">Customer Group 4:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_group4" name="cstm_dspch_group4"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Email Pickup:&nbsp;</label></div>
		<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_dspch_email_pickup" name="cstm_dspch_email_pickup"></div>
		<div class="col"><label class="col-form-label">Customer Group 4:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_dspch_group5" name="cstm_dspch_group5"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Priority:&nbsp;</label></div>
		<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_dspch_priority" name="cstm_dspch_priority"></div>
		<div class="col"><label class="col-form-label">One Container per Job:&nbsp;</label></div>
		<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_dspch_one_container_per_job" name="cstm_dspch_one_container_per_job"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Import Driver Notes:&nbsp;</label></div>
		<div class="col"><textarea class="form-control mt-1 my-text-height" rows="5" id="cstm_dspch_import_driver_notes" name="cstm_dspch_import_driver_notes"></textarea></div>
		<div class="col"><label class="col-form-label">Export Driver Notes:&nbsp;</label></div>
		<div class="col"><textarea class="form-control mt-1 my-text-height" rows="5" id="cstm_dspch_export_driver_notes" name="cstm_dspch_export_driver_notes"></textarea></div>
	</div>
