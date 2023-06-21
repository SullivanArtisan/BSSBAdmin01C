@extends('layouts.home_page_base')

@section('goback')
<?php
	if (isset($_GET['bookingTab'])) {
		$booking_tab = $_GET['bookingTab'];
	} else {
		$booking_tab = '';
	}

    if (isset($_GET['selJobId'])) {		// Enter this page from booking_selected.blade
        $booking = \App\Models\Booking::where('id', $_GET['selJobId'])->first();
        $container = \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', '<>', 'deleted')->first();
        $surcharges = \App\Models\ContainerSurcharge::where('cntnrsurchrg_cntnr_id', $container->id)->get();
        $cntnr_job_no = $booking->bk_job_no;
        $customerAcc = \App\Models\CstmAccountPrice::where('cstm_account_no', $booking->bk_cstm_account_no)->where('cstm_account_from', $booking->bk_pickup_cmpny_zone)->where('cstm_account_to', $booking->bk_delivery_cmpny_zone)->first();
        $totalCharge = $customerAcc->cstm_account_charge;
    } else {
        $id = '';
        $cntnr_job_no = "";
    }
    $outContents = "<a class=\"text-primary\" href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\" style=\"margin-right: 10px;\">Back</a>";
    echo $outContents;
?>
@show

@section('function_page')
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
	<style>
		.nav-tabs .nav-item .nav-link {
		  background-color: #A9DFBF;
		  color: #FFF;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.nav-tabs .nav-item .nav-link.active {
		  background-color: #FFF;
		  color: #117A65;
		  font-weight: bold;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.tab-content {
		  border: 1px solid #dee2e6;
		  border-top: transparent;
		  padding: 1px;
		}

		.tab-content .tab-pane {
		  background-color: #FFF;
		  color: #A9DFBF;
		  min-height: 200px;
		  height: auto;
		  padding: 10px 14px;
		}	
	</style>

    <div class="pb-5">
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Charges of Container {{$container->cntnr_name}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row bg-info text-white fw-bold ml-2">
                    <div class="col-6">Type</div>
                    <div class="col-3">Charge</div>
                    <div class="col-3">Ledger Code</div>
                </div> 

                <?php
                    foreach ($surcharges as $surcharge) {
                        $outContents = "<div id=\"".$surcharge->id."\" class=\"newpointer row ml-2\" onclick=\"doDispatch(this)\" ondblclick=\"\">";
                        $outContents .= "<div class=\"col-6\">";
                            $outContents .= $surcharge->cntnrsurchrg_type;
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $tempSurcharge = ($surcharge->cntnrsurchrg_quantity * $surcharge->cntnrsurchrg_rate) + $surcharge->cntnrsurchrg_charge;
                            $totalCharge += $tempSurcharge;
                            $outContents .= $tempSurcharge;
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $outContents .= $surcharge->cntnrsurchrg_ledger_code;
                        $outContents .= "</div>";
                        $outContents .= "</div><hr class=\"m-1\"/>";
                        {{ 					
                            echo $outContents;;
                        }}
                    }
                ?>
                <div class="row bg-secondary text-white fw-bold ml-2 mt-5">
                    <div class="col">Container's Total Charge:<span class="ml-5 text-warning">${{$totalCharge}}</span></div>
                </div> 
            </div>
            <div class="col bg-light mx-3">
                <form method="post" action="{{route('op_result.container_update', ['id'=>$booking->id])}}">
                    <div class="row mx-2 mt-2">
                        <div class="col-3"><label class="col-form-label">Type:&nbsp;</label></div>
                        <div class="col-9">
                            <input list="chrg_type_li" name="chrg_type" id="chrg_type" class="form-control mt-1 my-text-height" value="">
                                <datalist id="chrg_type_li">
                                    <?php
                                        $chrge_types = \App\Models\SurchargeType::all();
                                        foreach($chrge_types as $chrge_type) {
                                            $charge_output= "<option value=".str_replace(' ', '&nbsp;', $chrge_type->srchg_type).">";
                                            echo $charge_output;
                                        }
                                    ?>
                                </datalist>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Description:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" id="chrg_desc" name="chrg_desc">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">3rd Party Invoice #:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" id="chrg_3rd_pty_inv_no" name="chrg_3rd_pty_inv_no">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Quantity:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_quantity" name="chrg_quantity">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Rate:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_rate" name="chrg_rate">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col"><label class="col-form-label">Charge:&nbsp;</label></div>
                        <div class="col">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_charge" name="chrg_charge">
                        </div>
                        <div class="col"><label class="col-form-label">Override:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="chrg_override" name="chrg_override"></div>                        
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Ledger Code:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" readonly id="chrg_ledger_code" name="chrg_ledger_code">
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col"></div>
                        <div class="col">
                            <div class="row">
                                <button class="btn btn-success mx-4" type="submit" onclick="addThisSurcharge();">Add Accessorial Charge</button>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
        </div>

    </div>
	<script>
        function addThisSurcharge() {
            event.preventDefault();
            var token = "{{ csrf_token() }}";
            var cntnrName= {!!json_encode($container->cntnr_name)!!};
            var cntnrId = {!!json_encode($container->id)!!};
            var chargeType = document.getElementById('chrg_type').value;
            var chargeDesc = document.getElementById('chrg_desc').value;
            var charge3rdptyInvNo =document.getElementById('chrg_3rd_pty_inv_no').value;
            var chargeQuantity = document.getElementById('chrg_quantity').value;
            var chargeRate = document.getElementById('chrg_rate').value;
            var chargeCharge = document.getElementById('chrg_charge').value;
            var chargeOvrd = 'F';
            if (document.getElementById('chrg_override').checked) {
                chargeOvrd = 'T';
            }

            $.ajax({
                url: '/container_surcharge_add',
                type: 'POST',
                data: {
                    _token:token, 
                    cntnrsurchrg_cntnr_id:cntnrId,
                    cntnrsurchrg_type:chargeType, 
                    cntnrsurchrg_desc:chargeDesc, 
                    cntnrsurchrg_3rd_pty_inv_no:charge3rdptyInvNo, 
                    cntnrsurchrg_quantity:chargeQuantity, 
                    cntnrsurchrg_rate:chargeRate, 
                    cntnrsurchrg_charge:chargeCharge, 
                    cntnrsurchrg_override:chargeOvrd
                },    // the _token:token is for Laravel
                success: function(dataRetFromPHP) {
                    location.reload();
                    alert("Surcharge is added for container"+cntnrName+" successfully!");
                }
            });
        }
	</script>
@endsection
