<?php
	use App\Models\Container;
	use App\Models\Booking;
	use App\Models\SteamShipLine;
	use App\Models\ContainerSurcharge;
	use App\Models\container_completed;
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
    $bk_no = "";
    $status_completed = false;
	$id = $_GET['cntnrId'];
	if ($id) {
		$container = container_completed::where('ccntnr_id', $id)->first();
        if ($container->ccntnr_status == MyHelper::CntnrCompletedStaus()) {
            $status_completed = true;
        }
		$booking = Booking::where('id', $container->ccntnr_job_id)->first();
        $bk_no = $booking->bk_job_no;
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
					<h2 class="text-muted pl-2"><a href="{{route('booking_selected', ['selJobId'=>$booking->id])}}"><span class="text-primary">{{$bk_no}}</span></a>'s Container: {{$container->ccntnr_name}} (Status: {{$container->ccntnr_status}})</h2>
                    @endif
				</div>
				<div class="col ml-5">
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
							<div class="col-4"><input class="form-control mt-1" readonly type="text" name="cntnr_name" value="{{$container->ccntnr_name}}"></input></div>
                            @else
							<div class="col-4"><input class="form-control mt-1" readonly type="text" name="cntnr_name" value="{{$container->ccntnr_name}}"></input></div>
                            @endif
							<div class="col-2"><label class="col-form-label">Goods' Desc.:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_goods_desc" name="cntnr_goods_desc" id="cntnrGoodsDescInput" class="form-control mt-1" value="{{$container->ccntnr_goods_desc}}">
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
                                    <input list="cntnr_length" readonly name="cntnr_length" id="cntnrLengthInput" class="form-control mt-1" value="{{$container->ccntnr_length}}">
                                    <datalist id="cntnr_length">
                                    @foreach (MyHelper::$allContainerLengths as $length)
                                        <option value="{{$length}}">
                                    @endforeach
                                    </datalist>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_length" id="cntnrLengthInput" value="{{$container->ccntnr_length}}">
                                @endif
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Drop Only:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($container->ccntnr_droponly == 'T')
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly" checked>
                                @else
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly">
                                @endif
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Customs Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="date" id="cntnr_cstm_release_date" name="cntnr_cstm_release_date" value="{{$container->ccntnr_cstm_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customs Release Time:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="time" id="cntnr_cstm_release_time" name="cntnr_cstm_release_time" value="{{$container->ccntnr_cstm_release_time}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">SSL Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="date" id="cntnr_ssl_release_date" name="cntnr_ssl_release_date" value="{{$container->ccntnr_ssl_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">SSL Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="date" id="cntnr_ssl_lfd" name="cntnr_ssl_lfd" value="{{$container->ccntnr_ssl_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Terminal Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="date" id="cntnr_trmnl_lfd" name="cntnr_trmnl_lfd">
                            </div>
                            <div class="col-2"><label class="col-form-label">Type:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($booking == null)
                                    <input list="cntnr_type" name="cntnr_type" id="cntnr_type_li" class="form-control mt-1" value="{{$container->ccntnr_type}}">
                                    <datalist id="cntnr_type">
                                        @foreach (MyHelper::$allContainerTypes as $type)
                                            <option value="{{$type}}">
                                        @endforeach
                                    </datalist>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_type" id="cntnr_type_li" value="{{$container->ccntnr_type}}">
                                @endif
                                </input>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="text" id="cntnr_cargo_weight" name="cntnr_cargo_weight" value="{{$container->ccntnr_cargo_weight}}">
                            </div>
                            <div class="col-1">
                                <?php
                                $tagHead = "<input list=\"cntnr_weight_unit\" name=\"cntnr_weight_unit\" id=\"cntnrweightunitinput\" class=\"form-control mt-1\" ";
                                $tagTail = "><datalist id=\"cntnr_weight_unit\">";
                                $tagTail.= "<option value=\"Kgs\">";
                                $tagTail.= "<option value=\"Lbs\">";
                                $tagTail.= "</datalist>";
                                if ($container->ccntnr_weight_unit == 0) {
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
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_cost" name="cntnr_cost" value="{{$container->ccntnr_cost}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Surcharges:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_surcharges" name="cntnr_surcharges" value="{{$container->ccntnr_surcharges}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Discount:&nbsp;(%)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="1" id="cntnr_discount" name="cntnr_discount" value="{{$container->ccntnr_discount * 100}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Tax:&nbsp;(%)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="1" id="cntnr_tax" name="cntnr_tax" value="{{$container->ccntnr_tax * 100}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Total:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_total" name="cntnr_total" value="{{$container->ccntnr_total}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Net:&nbsp;($)</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_net" name="cntnr_net" value="{{$container->ccntnr_net}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col-4">
                                @if ($booking == null)
                                    <input list="cntnr_ssl" name="cntnr_ssl" id="cntnr_ssl_li" class="form-control mt-1 my-text-height" value="{{$container->ccntnr_ssl}}">
                                    <datalist id="cntnr_ssl">
                                    <?php
                                        foreach ($ssls as $ssl) {
                                            echo "<option value=\"".$ssl->ssl_name."\">";
                                        }
                                    ?>
                                    </datalist></input>
                                @else
                                    <input class="form-control mt-1" readonly type="text" name="cntnr_ssl" id="cntnr_ssl_li" value="{{$container->ccntnr_ssl}}">
                                @endif
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Chassis:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_chassis_type" name="cntnr_chassis_type" id="cntnr_chassis_type_li" class="form-control mt-1" value="{{$container->ccntnr_chassis_type}}">
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
                                <input list="cntnr_empty_return_trmnl" name="cntnr_empty_return_trmnl" id="cntnr_empty_return_trmnl_li" class="form-control mt-1" value="{{$container->ccntnr_empty_return_trmnl}}">
                                    <datalist id="cntnr_empty_return_trmnl">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">MT Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="date" id="cntnr_mt_lfd" name="cntnr_mt_lfd" value="{{$container->ccntnr_mt_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="text" id="cntnr_seal_no" name="cntnr_seal_no" value="{{$container->ccntnr_seal_no}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="text" id="cntnr_cstm_order_no" name="cntnr_cstm_order_no" value="{{$container->ccntnr_cstm_order_no}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            @if ($booking == null)
                            <div class="col-6"><input type="hidden" id="cntnr_job_no" name="cntnr_job_no" value="new"></div>
                            <div class="col-6"><input type="hidden" id="cntnr_cstm_account_name" name="cntnr_cstm_account_name" value="new"></div>
                            @else
                            <div class="col-2"><label class="col-form-label">Booking Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="text" id="cntnr_job_no" name="cntnr_job_no" value="{{$bk_no}}">
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
        </script>
	@endsection
}
@endif

	<?php
	?>

