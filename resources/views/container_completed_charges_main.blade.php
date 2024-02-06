@extends('layouts.home_page_base')

@section('goback')
<?php
	if (isset($_GET['bookingTab'])) {
		$booking_tab = $_GET['bookingTab'];
	} else {
		$booking_tab = '';
	}

    $surcharges_count = 0;

    if (isset($_GET['selJobId'])) {		// Enter this page from booking_selected.blade
        $booking = \App\Models\Booking::where('id', $_GET['selJobId'])->first();
        $container = \App\Models\container_completed::where('ccntnr_id', $_GET['cntnrId'])->first();
        $surcharges = \App\Models\ContainerSurcharge::orderBy('cntnrsurchrg_type')->where('cntnrsurchrg_cntnr_id', $container->ccntnr_id)->get();
        $cntnr_job_no = $booking->bk_job_no;
        $customerAcc = \App\Models\CstmAccountPrice::where('cstm_account_no', $booking->bk_cstm_account_no)->where('cstm_account_from', $booking->bk_pickup_cmpny_zone)->where('cstm_account_to', $booking->bk_delivery_cmpny_zone)->first();
        if ($customerAcc == null) {
            $customerAcc = \App\Models\CstmAccountPrice::where('cstm_account_no', $booking->bk_cstm_account_no)->first();
            if ($customerAcc == null) {
                $totalCharge = 0;
            } else {
                if ($customerAcc->cstm_account_charge == null) {
                    $totalCharge = 0;
                } else {
                    $totalCharge = $customerAcc->cstm_account_charge;
                }
            }
        } else {
            if ($customerAcc->cstm_account_charge == null) {
                $totalCharge = 0;
            } else {
                $totalCharge = $customerAcc->cstm_account_charge;
            }
        }
        $containerCharge = $totalCharge;

        if (isset($_GET['surchargeId'])) {
            $selSurcharge = \App\Models\ContainerSurcharge::where('id', $_GET['surchargeId'])->first();
            $parmSurchargeId = $selSurcharge->id;
        } else {
            $parmSurchargeId = 0;
        }

        if (!isset($_GET['parentPage'])) {
            $outContents = "<a class=\"text-primary\" href=\"".route('container_completed_selected', ['cntnrId='.$container->ccntnr_id, 'cntnrJobNo='.$booking->bk_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\" style=\"margin-right: 10px;\">Back</a>";
        } else {
            $outContents = "<a class=\"text-primary\" href=\"".route('container_completed_selected', ['cntnrId='.$container->ccntnr_id, 'cntnrJobNo='.$booking->bk_job_no, 'parentPage='.$_GET['parentPage']])."\" style=\"margin-right: 10px;\">Back</a>";
        }
    } else {
        $id = '';
        $cntnr_job_no = "";
    }

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
				<h2 class="text-muted pl-2">Surcharges of Container {{$container->ccntnr_name}}</h2>
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
                        $refreshUrlWithSurchargeId = route('container_completed_charges_main', ['cntnrId'=>$container->ccntnr_id, 'cntnrJobNo'=>$booking->bk_job_no, 'prevPage'=>'booking_selected', 'selJobId'=>$booking->id, 'surchargeId'=>$surcharge->id]);
                        $outContents = "<div id=\"scid".$surcharges_count."\" name=\"".$surcharge->id."\" class=\"newpointer row ml-2\" onclick=\"doDispatch(this)\" ondblclick=\"\">";
                        $outContents .= "<div class=\"col-6\">";
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= $surcharge->cntnrsurchrg_type;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            //$tempSurcharge = ($surcharge->cntnrsurchrg_quantity * $surcharge->cntnrsurchrg_rate) + $surcharge->cntnrsurchrg_charge;
                            $totalCharge += $surcharge->cntnrsurchrg_charge;
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= ltrim($surcharge->cntnrsurchrg_charge, "0");
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= $surcharge->cntnrsurchrg_ledger_code;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "</div><hr class=\"m-1\"/>";
                        {{ 					
                            echo $outContents;;
                        }}
                        $surcharges_count++;
                    }
                ?>
                <div class="row bg-secondary text-white fw-bold ml-2 mt-5">
                <div class="col">Surcharges:<span class="ml-5 text-warning">{{$surcharges_count}}</span></div>
                <div class="col">Total Charge:<span class="ml-5 text-warning">${{$totalCharge}}</span></div>
                    <div class="col">Container Rate:<span class="ml-5 text-warning">${{$containerCharge}}</span></div>
                </div> 
            </div>
            <div class="col mx-3" id="charge_details">
                    <div class="row mx-2 mt-2">
                        <div class="col-3"><label class="col-form-label">Type:&nbsp;</label></div>
                        <div class="col-9">
                            <input list="chrg_type_li" readonly name="chrg_type" id="chrg_type" class="form-control mt-1 my-text-height" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_type:''}}">
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
                            <input class="form-control mt-1 my-text-height" readonly type="text" id="chrg_desc" name="chrg_desc" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_desc:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">3rd Party Invoice #:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" readonly type="text" id="chrg_3rd_pty_inv_no" name="chrg_3rd_pty_inv_no" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_3rd_pty_inv_no:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Quantity:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="chrg_quantity" name="chrg_quantity" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_quantity:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Rate:&nbsp;($)</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="chrg_rate" name="chrg_rate" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_rate:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Charge:&nbsp;($)</label></div>
                        <div class="col-5">
                            <input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="chrg_charge" readonly name="chrg_charge" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_charge:''}}">
                        </div>
                        <div class="col-3"><label class="col-form-label">Override:&nbsp;</label></div>
                        <div class="col-1"><input type="checkbox" readonly class="mt-3" id="chrg_override" name="chrg_override" <?php if(isset($selSurcharge) && $selSurcharge->cntnrsurchrg_override=='T') {echo "checked";}?>></div>                        
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Ledger Code:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" readonly type="text" readonly id="chrg_ledger_code" name="chrg_ledger_code" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_ledger_code:''}}">
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col">
                            <div class="row">
                            </div>
                        </div>
                    </div>
			</div>
        </div>

    </div>
	<script>
        window.onload = function() {
            var surchargesCount = {!! json_encode($surcharges_count) !!};
            var parmSurchargeId = {!! json_encode($parmSurchargeId) !!};
            for (let idx = 0; idx < surchargesCount; idx++) {
                var elementId = "scid"+idx;
                scElement = document.getElementById(elementId);

                var elementName = scElement.getAttribute("name");
                if (elementName == parmSurchargeId) {
                    scElement.style.backgroundColor = 'lightgrey';
                } else {
                    scElement.style.backgroundColor = '';
                }
            }

            var elChgDetails = document.getElementById('charge_details');
            if (parmSurchargeId == 0) {
                elChgDetails.style.backgroundColor = 'white';
            } else {
                elChgDetails.style.backgroundColor = 'lightgrey';
            }
        }
	</script>
@endsection
