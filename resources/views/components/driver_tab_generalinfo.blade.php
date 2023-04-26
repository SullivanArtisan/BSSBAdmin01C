	<div class="row">
		<div class="col"><label class="col-form-label">Day/Night Shift:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_dayornight\" name=\"dvr_dayornight\" value=\"".$dbTable->dvr_dayornight."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_dayornight\" name=\"dvr_dayornight\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Fuel Card No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_fuel_card_no\" name=\"dvr_fuel_card_no\" value=\"".$dbTable->dvr_fuel_card_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_fuel_card_no\" name=\"dvr_fuel_card_no\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Mobile Data Type:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_data_type\" name=\"dvr_mobile_data_type\" value=\"".$dbTable->dvr_mobile_data_type."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_data_type\" name=\"dvr_mobile_data_type\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Mobile Call Sign:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_call_sign\" name=\"dvr_mobile_call_sign\" value=\"".$dbTable->dvr_mobile_call_sign."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_call_sign\" name=\"dvr_mobile_call_sign\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Mobile Phone No.:&nbsp;</label></div>
		<div class="col">
        <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_phone_no\" name=\"dvr_mobile_phone_no\" value=\"".$dbTable->dvr_mobile_phone_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_mobile_phone_no\" name=\"dvr_mobile_phone_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Out of Action:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_mobile_out_action\" name=\"dvr_mobile_out_action\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_mobile_out_action) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Alternative Data Type:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_data_type\" name=\"dvr_altern_data_type\" value=\"".$dbTable->dvr_altern_data_type."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_data_type\" name=\"dvr_altern_data_type\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Alternative Call Sign:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_call_sign\" name=\"dvr_altern_call_sign\" value=\"".$dbTable->dvr_altern_call_sign."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_call_sign\" name=\"dvr_altern_call_sign\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Alternative Phone No.:&nbsp;</label></div>
		<div class="col">
        <?php
            if(isset($dbTable)) {
                echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_phone_no\" name=\"dvr_altern_phone_no\" value=\"".$dbTable->dvr_altern_phone_no."\">";
            } else {
                echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_altern_phone_no\" name=\"dvr_altern_phone_no\">";
            }
        ?>
		</div>
		<div class="col"><label class="col-form-label">Out of Action:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_altern_out_action\" name=\"dvr_altern_out_action\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_altern_out_action) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Local Office:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_local_office\" name=\"dvr_local_office\" placeholder=\"".$dbTable->dvr_local_office."\"></textarea>";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_local_office\" name=\"dvr_local_office\"></textarea>";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">PAYE No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_paye_no\" name=\"dvr_paye_no\" placeholder=\"".$dbTable->dvr_paye_no."\"></textarea>";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_paye_no\" name=\"dvr_paye_no\"></textarea>";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Unavailable:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_unavailable\" name=\"dvr_unavailable\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if(!$dbTable->dvr_unavailable) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Unavailablity Comments:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_unavailability_comments\" name=\"dvr_unavailability_comments\" placeholder=\"".$dbTable->dvr_unavailability_comments."\"></textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_unavailability_comments\" name=\"dvr_unavailability_comments\"></textarea>";
				}
			?>
		</div>
	</div>
	<div class="row">
        <div class="col"><label class="col-form-label">Driver Type:&nbsp;</label></div>
		<div class="col">
			<?php
                if(isset($dbTable)) {
                    echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_type\" name=\"dvr_type\" value=\"".$dbTable->dvr_type."\">";
                } else {
                    echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_type\" name=\"dvr_type\">";
                }
			?>
		</div>
		<div class="col"><label class="col-form-label">HarbourLink Fuel Card:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_harbourlink_fuel_card\" name=\"dvr_harbourlink_fuel_card\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_harbourlink_fuel_card) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Start Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_start_date\" name=\"dvr_start_date\" value=\"".$dbTable->dvr_start_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_start_date\" name=\"dvr_start_date\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Termination Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_termination_date\" name=\"dvr_termination_date\" value=\"".$dbTable->dvr_termination_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_termination_date\" name=\"dvr_termination_date\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Return Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_return_date\" name=\"dvr_return_date\" value=\"".$dbTable->dvr_return_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_return_date\" name=\"dvr_return_date\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
