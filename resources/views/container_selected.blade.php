<?php
	use App\Models\Container;
	use App\Models\Booking;
	use App\Models\SteamShipLine;
	use App\Models\ContainerSurcharge;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
::-webkit-input-placeholder {
  color: white !important;
}
:-moz-placeholder {
  /* Firefox 18- */
  color: white !important;
}
::-moz-placeholder {
  /* Firefox 19+ */
  color: white !important;
}
:-ms-input-placeholder {
  color: white !important;
}
</style>

<?php
    $status_completed = false;
	$id = $_GET['cntnrId'];
	if ($id) {
		$container = Container::where('id', $id)->first();
        if ($container->cntnr_status == MyHelper::CntnrCompletedStaus()) {
            $status_completed = true;
        }
		$booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
    }

    if (isset($_GET['prevPage'])) {
        $prevPage = $_GET['prevPage'];
        $retParam = ['id'=>$id, 'prevPage'=>$prevPage, 'selJobId'=>$_GET['selJobId']];
    }

	$ssls = SteamShipLine::all();
?>

@section('goback')
    <?php
        if ($booking == null) {     // Enter this page by selecting a non-used container in the container_main page
            $ok_to_edit_surcharge = 1;
            if (!isset($_GET['parentPage'])) {
                $toThisLink = "<a class=\"text-primary\" href=\"".route('container_main')."\" style=\"margin-right: 10px;\">Back</a>";
            } else {
                $parentPage = $_GET['parentPage'];
                $toThisLink = "<a class=\"text-primary\" href=\"".route('container_main', ['page'=>$parentPage])."\" style=\"margin-right: 10px;\">Back</a>";
            }
        } else {                    // Enter this page by selecting a being-used container in the container_main page or a container in the booking_main page's respective booking's containers tab
            if (!isset($_GET['prevPage'])) {
                if (isset($_GET['parentPage'])) {
                    $parentPage = $_GET['parentPage'];
                    $toThisLink = "<a class=\"text-primary\" href=\"".route('container_main', ['page'=>$parentPage])."\" style=\"margin-right: 10px;\">Back</a>";
                } else {
                    $toThisLink = "<a class=\"text-primary\" href=\"".route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id])."\" style=\"margin-right: 10px;\">Back</a>";
                }
            } else {
                $toThisLink = "<a class=\"text-primary\" href=\"".route($prevPage, ['selJobId'=>$_GET['selJobId']])."\" style=\"margin-right: 10px;\">Back</a>";
            }

            if ($booking->bk_status == MyHelper::BkInvoicedStaus() || $booking->bk_status == MyHelper::BkFullyPaidStaus() || $booking->bk_status == MyHelper::BkPartialyPaidStaus()) {
                $ok_to_edit_surcharge = 0;
            } else {
                $ok_to_edit_surcharge = 1;
            }
        }
        echo $toThisLink;
    ?>
@show

@if (!$id or !$container) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Container Operation</h2>
				</div>
				<div class="col"></div>
			</div>
		</div>
		
		<div class="alert alert-success m-4">
			<?php
				echo "<span style=\"color:red\">Data cannot NOT be found!</span>";
			?>
		</div>
	@endsection
}
@else {
	@section('function_page')
		<div>
			<div class="row m-4">
				<div>
                    @if ($booking)
					<h2 class="text-muted pl-2"><a href="{{route('booking_selected', ['selJobId'=>$booking->id])}}"><span class="text-primary">{{$container->cntnr_job_no}}</span></a>'s Container: {{$container->cntnr_name}} (Status: {{$container->cntnr_status}})</h2>
                    @else
					<h2 class="text-muted pl-2">New Container: {{$container->cntnr_name}} (Status: {{$container->cntnr_status}})</h2>
                    @endif
				</div>
				<div class="col ml-5">
                    @if ($booking)
					<button class="btn btn-danger" type="button"><a href="{{route('container_remove', ['id'=>$id])}}" onclick="return myRemovalConfirmation();">Remove</a></button>
                        @if (!isset($_GET['parentPage'])) 
					    <button class="btn btn-primary ml-4" type="button"><a href="{{route('container_charges_main', ['cntnrId'=>$id, 'cntnrJobNo'=>$container->cntnr_job_no, 'prevPage'=>'booking_selected', 'selJobId'=>$booking->id])}}" onclick="return surchargeConfirmation();">Edit Surcharges</a></button>
                        @else
					    <button class="btn btn-primary ml-4" type="button"><a href="container_charges_main?cntnrId={{$id}}&cntnrJobNo={{$container->cntnr_job_no}}&parentPage={{$parentPage}}&selJobId={{$booking->id}}" onclick="return surchargeConfirmation();">Edit Surcharges</a></button>
                        @endif
                    @else
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-danger" type="button"><a href="{{route('container_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
                        </div>
                        <div class="col-10">
                            <?php
                            $available_bookings = Booking::where('bk_status', MyHelper::BkCreatedStaus())->orwhere('bk_status', 'LIKE', '%sent%')->get();
                            ?>
                            <input list="avail_bks" type='text' oninput='AddToThisBooking()' class="bg-success border-primary border-4 form-control" name="avail_bks" id="availBksInput" placeholder="Add it to a Booking">
                                <datalist id="avail_bks">
                                    @foreach ($available_bookings as $available_bk)
                                    <option value="{{ $available_bk->bk_job_no  }}">
                                    @endforeach
                                </datalist>
                        </div>
                    </div>
                    @endif
                </div>
			</div>
		</div>
		<div>
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="row">
				<div class="col">
                    @if (!isset($prevPage))
					<form method="post" action="{{route('op_result.container_update', ['id'=>$id])}}">
                    @else
					<form method="post" action="{{route('op_result.container_update', $retParam)}}">
                    @endif
						@csrf
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Container Name:&nbsp;</label><span class="text-danger">*</span></div>
                            @if ($booking == null)
							<div class="col-4"><input class="form-control mt-1" type="text" name="cntnr_name" value="{{$container->cntnr_name}}"></input></div>
                            @else
							<div class="col-4"><input class="form-control mt-1" readonly type="text" name="cntnr_name" value="{{$container->cntnr_name}}"></input></div>
                            @endif
							<div class="col-2"><label class="col-form-label">Goods' Desc.:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_goods_desc" name="cntnr_goods_desc" id="cntnrGoodsDescInput" class="form-control mt-1" value="{{$container->cntnr_goods_desc}}">
                                <datalist id="cntnr_goods_desc">
                                    <option value="General Freight">
                                    <option value="Dangourous Goods">
                                    <option value="Refrigerated Goods">
                                    <option value="High Value Goods">
                                </datalist>
                            </div>
                        </div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Container Length:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($booking == null)
                                    <input list="cntnr_length" name="cntnr_length" id="cntnrLengthInput" class="form-control mt-1" value="{{$container->cntnr_length}}">
                                    <datalist id="cntnr_length">
                                    @foreach (MyHelper::$allContainerLengths as $length)
                                        <option value="{{$length}}">
                                    @endforeach
                                    </datalist>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_length" id="cntnrLengthInput" value="{{$container->cntnr_length}}">
                                @endif
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Drop Only:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($container->cntnr_droponly == 'T')
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly" checked>
                                @else
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly">
                                @endif
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Customs Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="date" id="cntnr_cstm_release_date" name="cntnr_cstm_release_date" value="{{$container->cntnr_cstm_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customs Release Time:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="time" id="cntnr_cstm_release_time" name="cntnr_cstm_release_time" value="{{$container->cntnr_cstm_release_time}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">SSL Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="date" id="cntnr_ssl_release_date" name="cntnr_ssl_release_date" value="{{$container->cntnr_ssl_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">SSL Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="date" id="cntnr_ssl_lfd" name="cntnr_ssl_lfd" value="{{$container->cntnr_ssl_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Terminal Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="date" id="cntnr_trmnl_lfd" name="cntnr_trmnl_lfd">
                            </div>
                            <div class="col-2"><label class="col-form-label">Type:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($booking == null)
                                    <input list="cntnr_type" name="cntnr_type" id="cntnr_type_li" class="form-control mt-1" value="{{$container->cntnr_type}}">
                                    <datalist id="cntnr_type">
                                        @foreach (MyHelper::$allContainerTypes as $type)
                                            <option value="{{$type}}">
                                        @endforeach
                                    </datalist>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_type" id="cntnr_type_li" value="{{$container->cntnr_type}}">
                                @endif
                                </input>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="text" id="cntnr_cargo_weight" name="cntnr_cargo_weight" value="{{$container->cntnr_cargo_weight}}">
                            </div>
                            <div class="col-1">
                                <?php
                                $tagHead = "<input list=\"cntnr_weight_unit\" name=\"cntnr_weight_unit\" id=\"cntnrweightunitinput\" class=\"form-control mt-1\" ";
                                $tagTail = "><datalist id=\"cntnr_weight_unit\">";
                                $tagTail.= "<option value=\"Kgs\">";
                                $tagTail.= "<option value=\"Lbs\">";
                                $tagTail.= "</datalist>";
                                if ($container->cntnr_weight_unit == 0) {
                                    echo $tagHead."placeholder=\"Kgs\" value=\"Kgs\"".$tagTail;
                                } else {
                                    echo $tagHead."placeholder=\"Lbs\" value=\"Lbs\"".$tagTail;
                                }
                                ?>
                            </div>
                            <div class="col-5"><input type="hidden" class="form-control mt-1" type="text"></div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Cost:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="number" step="0.01" id="cntnr_cost" name="cntnr_cost" value="{{$container->cntnr_cost}}" onchange="getNewPrices()">
                            </div>
                            <div class="col-2"><label class="col-form-label">Surcharges:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_surcharges" name="cntnr_surcharges" value="{{$container->cntnr_surcharges}}" onchange="getNewPrices()">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Discount:&nbsp;(%)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="number" step="1" id="cntnr_discount" name="cntnr_discount" value="{{$container->cntnr_discount * 100}}" onchange="getNewPrices()">
                            </div>
                            <div class="col-2"><label class="col-form-label">Tax:&nbsp;(%)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="1" id="cntnr_tax" name="cntnr_tax" value="{{$container->cntnr_tax * 100}}" onchange="getNewPrices()">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Total:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_total" name="cntnr_total" value="{{$container->cntnr_total}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Net:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_net" name="cntnr_net" value="{{$container->cntnr_net}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col-4">
                                @if ($booking == null)
                                    <input list="cntnr_ssl" name="cntnr_ssl" id="cntnr_ssl_li" class="form-control mt-1 my-text-height" value="{{$container->cntnr_ssl}}">
                                    <datalist id="cntnr_ssl">
                                    <?php
                                        foreach ($ssls as $ssl) {
                                            echo "<option value=\"".$ssl->ssl_name."\">";
                                        }
                                    ?>
                                    </datalist></input>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_ssl" id="cntnr_ssl_li" value="{{$container->cntnr_ssl}}">
                                @endif
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Chassis:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_chassis_type" name="cntnr_chassis_type" id="cntnr_chassis_type_li" class="form-control mt-1" value="{{$container->cntnr_chassis_type}}">
                                    <datalist id="cntnr_chassis_type">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Empty Return Depot:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_empty_return_trmnl" name="cntnr_empty_return_trmnl" id="cntnr_empty_return_trmnl_li" class="form-control mt-1" value="{{$container->cntnr_empty_return_trmnl}}">
                                    <datalist id="cntnr_empty_return_trmnl">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">MT Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="date" id="cntnr_mt_lfd" name="cntnr_mt_lfd" value="{{$container->cntnr_mt_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="text" id="cntnr_seal_no" name="cntnr_seal_no" value="{{$container->cntnr_seal_no}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="text" id="cntnr_cstm_order_no" name="cntnr_cstm_order_no" value="{{$container->cntnr_cstm_order_no}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            @if ($booking == null)
                            <div class="col-6"><input type="hidden" id="cntnr_job_no" name="cntnr_job_no" value="new"></div>
                            <div class="col-6"><input type="hidden" id="cntnr_cstm_account_name" name="cntnr_cstm_account_name" value="new"></div>
                            @else
                            <div class="col-2"><label class="col-form-label">Booking Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="text" id="cntnr_job_no" name="cntnr_job_no" value="{{$container->cntnr_job_no}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">&nbsp;</label></div>
                            <div class="col-4"><input type="hidden" class="form-control mt-1" type="text"></div>
                            @endif
                        </div>
					    <div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
                                    <?php
                                        if ($booking == null) {
                                            if (!isset($_GET['parentPage'])) {
                                                $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('container_main')."\">Cancel</a></button>";
                                            } else {
                                                $parentPage = $_GET['parentPage'];
                                                $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('container_main', ['page'=>$parentPage])."\">Cancel</a></button>";
                                            }
                                        } else {
                                            if (!isset($_GET['prevPage'])) {
                                                if (isset($_GET['parentPage'])) {
                                                    $parentPage = $_GET['parentPage'];
                                                    $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('container_main', ['page'=>$parentPage])."\">Cancel</a></button>";
                                                } else {
                                                    $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id])."\">Cancel</a></button>";
                                                }
                                            } else {
                                                $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route($_GET['prevPage'], ['selJobId'=>$_GET['selJobId']])."\">Cancel</a></button>";
                                            }
                                        }
                                        echo $toThisLink;
                                    ?>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	
        <script>
            var cntnr_cost          = 0;
            var cntnr_surcharges    = 0;
            var cntnr_discount      = 0;
            var cntnr_tax           = 0;
            var cntnr_total         = 0;
            var cntnr_net           = 0;
            
            function getAllPrices() {
				cntnr_cost = document.getElementById("cntnr_cost").value;
				cntnr_surcharges = document.getElementById("cntnr_surcharges").value;
				cntnr_discount = document.getElementById("cntnr_discount").value/100;
				cntnr_tax = document.getElementById("cntnr_tax").value/100;
				cntnr_total = document.getElementById("cntnr_total").value;
				cntnr_net = document.getElementById("cntnr_net").value;
            }

            function getNewTotal() {
                getAllPrices();
                cntnr_total = ((cntnr_cost* 10) / 10 + (cntnr_surcharges* 10) / 10) * (1 + (cntnr_tax * 10) / 10);
            }

            function getNewNet() {
                getNewTotal();
                temp_total = ((cntnr_total* 10) / 10);
                cntnr_net = temp_total - (temp_total * ((cntnr_discount* 10) / 10));
            }

			function myConfirmation() {
				if(!confirm("Are you sure to delete this container?"))
				event.preventDefault();
			}

			function surchargeConfirmation() {
				let okToEditSurcharge  = {!! json_encode($ok_to_edit_surcharge) !!};

				if (0 == okToEditSurcharge) {
					event.preventDefault();
					alert("\r\nSorry!!\r\nYou cannot edit the surcharges now.");
				}
			}

			function myRemovalConfirmation() {
                var statusCompleted = {!! json_encode($status_completed) !!};
                
                if (true == statusCompleted) {
                    alert("\r\nSorry!!\r\nThis container is completed, so you cannot remove it from its booking.");
                    event.preventDefault();
                } else {
                    if(!confirm("Are you sure to remove this container from the booking?"))
				        event.preventDefault();
                }
			}

			function getNewPrices() {
                getNewNet();
                document.getElementById("cntnr_total").value= cntnr_total.toFixed(2);
				document.getElementById("cntnr_net").value  = cntnr_net.toFixed(2);
			}

            getNewPrices();

            function AddToThisBooking() {
                var selBooking = document.getElementById("availBksInput").value;
                if (confirm("Are you sure to add this container to the booking "+selBooking+"?")) {
                    url = './ContainerAddedToBooking?cntnrId='+{!!json_encode($id)!!}+'&bkName='+selBooking;
                    window.location = url;
                }
            }
        </script>
	@endsection
}
@endif

	<?php
	?>

