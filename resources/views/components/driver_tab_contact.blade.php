	<div class="row">
		<div class="col"><label class="col-form-label">PowerUnit No. 1:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_1\" name=\"dvr_pwr_unit_no_1\" value=\"".$dbTable->dvr_pwr_unit_no_1."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_1\" name=\"dvr_pwr_unit_no_1\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">PowerUnit No. 2:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_2\" name=\"dvr_pwr_unit_no_2\" value=\"".$dbTable->dvr_pwr_unit_no_2."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_2\" name=\"dvr_pwr_unit_no_2\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Name:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_name\" name=\"dvr_name\" value=\"".$dbTable->dvr_name."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_name\" name=\"dvr_name\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Driver No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_no\" name=\"dvr_no\" value=\"".$dbTable->dvr_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_no\" name=\"dvr_no\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_address\" name=\"dvr_address\" value=\"".$dbTable->dvr_address."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_address\" name=\"dvr_address\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">City:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_city\" name=\"dvr_city\" value=\"".$dbTable->dvr_city."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_city\" name=\"dvr_city\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_province\" name=\"dvr_province\" value=\"".$dbTable->dvr_province."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_province\" name=\"dvr_province\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Postal Code:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_postcode\" name=\"dvr_postcode\" value=\"".$dbTable->dvr_postcode."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_postcode\" name=\"dvr_postcode\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_country\" name=\"dvr_country\" value=\"".$dbTable->dvr_country."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_country\" name=\"dvr_country\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Cell Phone:&nbsp;</label></div>
		<div class="col">
			<?php
                use App\Helper\MyHelper;

                if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_cell_phone\" name=\"dvr_cell_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_cell_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_cell_phone\" name=\"dvr_cell_phone\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Home Phone:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_home_phone\" name=\"dvr_home_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_home_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_home_phone\" name=\"dvr_home_phone\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Other Phone:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_other_phone\" name=\"dvr_other_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_other_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_other_phone\" name=\"dvr_other_phone\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_email\" name=\"dvr_email\" value=\"".$dbTable->dvr_email."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_email\" name=\"dvr_email\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_ops_code\" name=\"dvr_ops_code\" value=\"".$dbTable->dvr_ops_code."\">";
                    echo "<input list=\"dvr_ops_code\" name=\"dvr_ops_code\" id=\"opsCodeInput\" class=\"form-control mt-1 my-text-height\" value=\"".$dbTable->dvr_ops_code."\">";
				} else {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_ops_code\" name=\"dvr_ops_code\">";
                    echo "<input list=\"dvr_ops_code\" name=\"dvr_ops_code\" id=\"opsCodeInput\" class=\"form-control mt-1 my-text-height\">";
				}
			?>
            <datalist id="dvr_ops_code">
            <option value="Local">
            <option value="Highway">
            <option value="Admin">
            </datalist>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Emergency Contact:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_contact\" name=\"dvr_emergency_contact\" value=\"".$dbTable->dvr_emergency_contact."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_contact\" name=\"dvr_emergency_contact\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Emergency Phone No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_phone\" name=\"dvr_emergency_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_emergency_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_phone\" name=\"dvr_emergency_phone\">";
				}
			?>
		</div>
	</div>
