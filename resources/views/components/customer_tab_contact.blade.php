	<div class="row">
		<div class="col"><label class="col-form-label">Account Number:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_account_no\" name=\"cstm_account_no\" value=\"".$dbTable->cstm_account_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_account_no\" name=\"cstm_account_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Name:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_name" name="cstm_contact_invoice_name"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Name:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_name" name="cstm_account_name"></div>
		<div class="col"><label class="col-form-label">Invoice Address:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_addr" name="cstm_contact_invoice_addr"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Address:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_address" name="cstm_address"></div>
		<div class="col"><label class="col-form-label">Invoice City:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_city" name="cstm_contact_invoice_city"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account City:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_city" name="cstm_city"></div>
		<div class="col"><label class="col-form-label">Invoice Province:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_province" name="cstm_contact_invoice_province"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Province:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_province" name="cstm_province"></div>
		<div class="col"><label class="col-form-label">Invoice Postcode:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_postcode" name="cstm_contact_invoice_postcode"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Postcode:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_postcode" name="cstm_postcode"></div>
		<div class="col"><label class="col-form-label">Invoice Country:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_invoice_country" name="cstm_contact_invoice_country"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Country:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_country" name="cstm_country"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Zone:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_zone" name="cstm_zone"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Name 1:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_name1" name="cstm_contact_name1"></div>
		<div class="col"><label class="col-form-label">Contact Tel 1:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_tel1" name="cstm_contact_tel1"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Email 1:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_email1" name="cstm_contact_email1"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Name 2:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_name2" name="cstm_contact_name2"></div>
		<div class="col"><label class="col-form-label">Contact Tel 2:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_tel2" name="cstm_contact_tel2"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Email 2:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_email2" name="cstm_contact_email2"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Name 3:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_name3" name="cstm_contact_name3"></div>
		<div class="col"><label class="col-form-label">Contact Tel 3:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_tel3" name="cstm_contact_tel3"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Contact Email 3:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_contact_email3" name="cstm_contact_email3"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Contact Name:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_contact" name="cstm_account_contact"></div>
		<div class="col"><label class="col-form-label">Account Tel:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_tel" name="cstm_account_tel"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Account Email:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_email" name="cstm_account_email"></div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Fax:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_fax" name="cstm_fax"></div>
		<div class="col"><label class="col-form-label">HST Number:&nbsp;</label></div>
		<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_hst_no" name="cstm_hst_no"></div>
	</div>
