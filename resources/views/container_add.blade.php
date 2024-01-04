<?php
	use App\Models\Driver;
    use App\Helper\MyHelper;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('container_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div>
		<?php
		if (isset($_GET['bookingResult'])) {
			$container_result = $_GET['bookingResult'];
		} else {
			$container_result = '';
		}
        $ssls = \App\Models\SteamShipLine::all();
		$cntnr_job_no = MyHelper::CntnrNewlyCreated();
		?>
		<div class="row"><div class="col-3"><h2 class="text-muted pl-2 mb-2">Enter a New Container</h2></div><div class="col-9 mt-2"><?php echo $container_result;?></div></div>
	</div>
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
    <link rel="stylesheet" href="css/all_tabs_for_customers.css">

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

		<div class="col-md-12 mb-4">
			<form method="post" id="form_container_add" action="{{route('container_add_new')}}">
				@csrf
                <div class="card mb-4" id="card_create">
                    <div class="card-body">
                        <!-- <div class="row">
                            <h5 class="card-title ml-2">New Container</h5>
                        </div> -->
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Container Name:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_name name=cntnr_name>
                            </div>
                            <div class="col-2"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_goods_desc name=cntnr_goods_desc>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Container Length:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_length" name="cntnr_length" id="cntnr_length_li" placeholder="40" class="form-control mt-1 my-text-height">
                                    <datalist id="cntnr_length">
                                    @foreach (MyHelper::$allContainerLengths as $length)
                                        <option value="{{$length}}">
                                    @endforeach
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Drop Only:&nbsp;</label></div>
                            <div class="col-4">
                                <input type=checkbox style=margin-top:3% id="cntnr_drop_only" name="cntnr_drop_only">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Customs Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_cstm_release_date name=cntnr_cstm_release_date>
                            </div>
                            <div class="col-2"><label class="col-form-label">Customs Release Time:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=time id=cntnr_cstm_release_time name=cntnr_cstm_release_time>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">SSL Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_release_date name=cntnr_ssl_release_date>
                            </div>
                            <div class="col-2"><label class="col-form-label">SSL Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_lfd name=cntnr_ssl_lfd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Terminal Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_trmnl_lfd name=cntnr_trmnl_lfd>
                            </div>
                            <div class="col-2"><label class="col-form-label">&nbsp;</label></div>
                            <div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_cargo_weight name=cntnr_cargo_weight>
                            </div>
                            <div class="col-1">
                                <?php
                                $tagHead = "<input list=\"cntnr_weight_unit\" name=\"cntnr_weight_unit\" id=\"cntnrweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
                                $tagTail = "><datalist id=\"cntnr_weight_unit\">";
                                $tagTail.= "<option value=\"Kgs\">";
                                $tagTail.= "<option value=\"Lbs\">";
                                $tagTail.= "</datalist>";
                                echo $tagHead."placeholder=\"Kgs\" value=\"Kgs\"".$tagTail;
                                ?>
                            </div>
                            <div class="col-5"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Cost:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="number" step="0.01" id="cntnr_cost" name="cntnr_cost" placeholder="0.0" onchange="getNewPrices()">
                            </div>
                            <div class="col-2"><label class="col-form-label">Surcharges:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_surcharges" name="cntnr_surcharges" placeholder="0.0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Discount:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="number" step="0.01" id="cntnr_discount" name="cntnr_discount" placeholder="0.0" onchange="getNewPrices()">
                            </div>
                            <div class="col-2"><label class="col-form-label">Tax:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" type="number" step="0.01" id="cntnr_tax" name="cntnr_tax" placeholder="0.12" onchange="getNewPrices()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Total:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_total" name="cntnr_total" placeholder="0.0">
                            </div>
                            <div class="col-2"><label class="col-form-label">Net:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_net" name="cntnr_net" placeholder="0.0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col-4">
                                <input list="cntnr_ssl" name="cntnr_ssl" id="cntnr_ssl_li" class="form-control mt-1 my-text-height">
                                <datalist id="cntnr_ssl">
                                <?php
                                    foreach ($ssls as $ssl) {
                                        echo "<option value=\"".$ssl->ssl_name."\">";
                                    }
                                ?>
                                </datalist></input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Chassis:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_chassis_type" name="cntnr_chassis_type" id="cntnr_chassis_type_li" class="form-control mt-1 my-text-height">
                                    <datalist id="cntnr_chassis_type">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Empty Return Depot:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_empty_return_trmnl" name="cntnr_empty_return_trmnl" id="cntnr_empty_return_trmnl_li" class="form-control mt-1 my-text-height">
                                    <datalist id="cntnr_empty_return_trmnl">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">MT Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control" mt-1 my-text-height type="date" id="cntnr_mt_lfd" name="cntnr_mt_lfd">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1 my-text-height" type="text" id="cntnr_seal_no" name="cntnr_seal_no">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class="form-control mt-1 my-text-height" type="text" id="cntnr_cstm_order_no" name="cntnr_cstm_order_no">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"><input type="hidden" id="cntnr_job_no" name="cntnr_job_no" value="new"></div>
                            <div class="col-6"><input type="hidden" id="cntnr_cstm_account_name" name="cntnr_cstm_account_name" value="new"></div>
                        </div>
                    </div>	
                </div>	
				<div class="row my-3">
					<div class="w-25"></div>
					<div class="col">
						<div class="row">
							<button class="btn btn-success mx-4" type="submit" onclick="AddNewContainer(event)">Add</button>
							<button class="btn btn-secondary mx-3" type="button"><a href="{{route('container_main')}}">Cancel</a></button>
						</div>
					</div>
					<div class="col"></div>
				</div>
			</form>
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
            cntnr_cost = cntnr_cost === ''? document.getElementById("cntnr_cost").placeholder : cntnr_cost;
            cntnr_surcharges = document.getElementById("cntnr_surcharges").value;
            cntnr_surcharges = cntnr_surcharges === ''? document.getElementById("cntnr_surcharges").placeholder : cntnr_surcharges;
            cntnr_discount = document.getElementById("cntnr_discount").value;
            cntnr_discount = cntnr_discount === ''? document.getElementById("cntnr_discount").placeholder: cntnr_discount;
            cntnr_tax = document.getElementById("cntnr_tax").value;
            cntnr_tax = cntnr_tax === ''? document.getElementById("cntnr_tax").placeholder : cntnr_tax;
        }

        function getNewTotal() {
            getAllPrices();
            cntnr_total = ((cntnr_cost* 10) / 10 + (cntnr_surcharges* 10) / 10) * (1 + (cntnr_tax * 10) / 10);
        }

        function getNewNet() {
            getNewTotal();
            cntnr_net = ((cntnr_total* 10) / 10) - ((cntnr_discount* 10) / 10);
        }

        function getNewPrices() {
            getNewNet();
            document.getElementById("cntnr_total").value= cntnr_total.toFixed(2);
            document.getElementById("cntnr_net").value  = cntnr_net.toFixed(2);
        }

        function AddNewContainer(e) {
            e.preventDefault();
            var token = "{{ csrf_token() }}";
            var cntnr_job_no = {!! json_encode($cntnr_job_no) !!};
            var cntnr_name = document.getElementById("cntnr_name").value;
            var cntnr_ssl = document.getElementById("cntnr_ssl_li").value;
            if (cntnr_ssl.length == 0) {
                alert("Please enter the steamship line's name first!");
            } else if (cntnr_name.length == 0) {
                alert("Please enter the container's name first!");
            } else {
                var cntnr_cost = document.getElementById("cntnr_cost").value;
                    cntnr_cost = cntnr_cost === ''? document.getElementById("cntnr_cost").placeholder : cntnr_cost;
                var cntnr_surcharges = document.getElementById("cntnr_surcharges").value;
                    cntnr_surcharges = cntnr_surcharges === ''? document.getElementById("cntnr_surcharges").placeholder : cntnr_surcharges;
                var cntnr_discount = document.getElementById("cntnr_discount").value;
                    cntnr_discount = cntnr_discount === ''? document.getElementById("cntnr_discount").placeholder: cntnr_discount;
                var cntnr_tax = document.getElementById("cntnr_tax").value;
                    cntnr_tax = cntnr_tax === ''? document.getElementById("cntnr_tax").placeholder : cntnr_tax;
                var cntnr_total = document.getElementById("cntnr_total").value;
                    cntnr_total = cntnr_total === ''? document.getElementById("cntnr_total").placeholder : cntnr_total;
                var cntnr_net = document.getElementById("cntnr_net").value;
                    cntnr_net = cntnr_net === ''? document.getElementById("cntnr_net").placeholder : cntnr_net;
                var cntnr_goods_desc = document.getElementById("cntnr_goods_desc").value;
                $.ajax({
                    url: '/container_add_new',
                    type: 'POST',
                    data: {_token:token, cntnr_job_no:cntnr_job_no, cntnr_name:cntnr_name, cntnr_ssl:cntnr_ssl,	cntnr_goods_desc:cntnr_goods_desc, cntnr_cost:cntnr_cost, cntnr_surcharges:cntnr_surcharges, cntnr_discount:cntnr_discount, cntnr_tax:cntnr_tax, cntnr_total:cntnr_total, cntnr_net:cntnr_net},    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        location.href = location.href;
                        alert("Container "+cntnr_name+" is created successfully!");
                    },
                    error: function(err) {
                        console.log(err);
                        alert(err);
                    }
                });
            }
        }
	</script>	
	<!--
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	-->
@endsection
