
<?php

	if (isset($_GET['bookingTab'])) {
		$booking_tab = $_GET['bookingTab'];
	} else {
		$booking_tab = '';
	}

	$ssls = \App\Models\SteamShipLine::all();
	$available_containers = [];
	if (isset($_GET['id'])) {				// Enter this page from booking_add.blade
		$id = $_GET['id'];
		$booking = \App\Models\Booking::where('id', $id)->first();
		$containers = \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', '<>', 'deleted')->orderBy('cntnr_name', 'asc')->get();
		$cntnr_job_no = $booking->bk_job_no;
	} else {
		if (isset($_GET['selJobId'])) {		// Enter this page from booking_selected.blade
			$containers 			= \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', '<>', 'deleted')->orderBy('cntnr_name', 'asc')->get();
			$available_containers 	= \App\Models\Container::where('cntnr_job_no', MyHelper::CntnrNewlyCreated())->where('cntnr_status', '<>', 'deleted')->orderBy('cntnr_name', 'asc')->get();
			$cntnr_job_no 			= $booking->bk_job_no;
		} else {
			$id = '';
			$containers = [];
			$cntnr_job_no = "";
		}
	}


	// Title Line
	$outContents = "<div class=\"container mw-100\">";
	$outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Container Name";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-3 mt-1 align-middle\">";
			$outContents .= "Status";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-1 mt-1 align-middle\">";
			$outContents .= "Length";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Type";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Total Movements";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 align-middle\">";
			$outContents .= "";
			//$outContents .= "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('booking_main')."\">Process Movements</a></button>";
		$outContents .= "</div>";
	$outContents .= "</div>";
	echo $outContents;

	// Body Lines
	$selected_container	 = "";
	$selected_containers = array();
	$listed_containers = 0;
	if (sizeof($containers) > 0) {
		foreach ($containers as $container) {
			$selected_container = $container->id;
			$listed_containers++;
			if ($listed_containers % 2) {
				$outContents = "<div class=\"row\" style=\"background-color:Lavender\">";
			} else {
				$outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
			}
			$outContents .= "<div class=\"col-2\">";
				if (!isset($_GET['selJobId'])) {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no])."\">";
				} else {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\">";
				}
				$outContents .= $container->cntnr_name;
				$outContents .= "</a>";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				if (!isset($_GET['selJobId'])) {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no])."\">";
				} else {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\">";
				}
				if (($container->cntnr_status == MyHelper::CntnrDispatchedStaus()) && (strlen($container->cntnr_dvr_no) > 0)) {
					$driver = \App\Models\Driver::where('dvr_no', $container->cntnr_dvr_no)->first();
					$outContents .= $container->cntnr_status.' : <span class="text-info">'.$driver->dvr_name.'</span>';
				} else {
					$outContents .= $container->cntnr_status;
				}
				$outContents .= "</a>";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= $container->cntnr_length;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= $container->cntnr_type;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= MyHelper::GetTotalMovements($booking->id, $container->cntnr_name).' <span class="text-info">( $'.$container->cntnr_net.')</span>';
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "<button class=\"btn btn-success btn-sm my-1\" type=\"button\"><a href=\"".route('movements_selected', ['cntnrId'=>$container->id])."\">Get Ready!</a></button>";
			$outContents .= "</div>";
			$outContents .= "</div>";
			echo $outContents;
		}
	} else {
		$outContents = "<div><p class=\"text-danger\">This booking has 0 container now!</p></br></div>";
		echo $outContents;
	}
	?>

	<?php
	$outContents = "</div>";
	echo $outContents;
	?>

<?php
$c_names = [];
$total_containers = 0;
?>
@if (!isset($booking) || (isset($booking) && (!strstr($booking->bk_status, MyHelper::BkCompletedStaus()))))
	<div class="row mt-5 mb-2 h5">
		<div class="ml-1 col-2"><label>Add a Container by:</label></div>
		<div class="ml-1 col-2"><input type="radio" name="ContainerAddWays" id="rdoCreateContainer" onclick="RadioCreateClicked()" value="create" class="text-lg" checked> Creating a New One</input></div>
		<div class="ml-1 col-4"><input type="radio" name="ContainerAddWays" id="rdoSelectContainer" onclick="RadioSelectClicked()" value="select" > Selecting an Existing One</input></div>
	</div>
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
				<div class="col-2"><label class="col-form-label">Type:&nbsp;</label></div>
				<div class="col-4">
					<input list="cntnr_type" name="cntnr_type" id="cntnr_type_li" placeholder="Shipping" class="form-control mt-1 my-text-height">
						<datalist id="cntnr_type">
							@foreach (MyHelper::$allContainerTypes as $type)
								<option value="{{$type}}">
							@endforeach
						</datalist>
					</input>
				</div>
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
				<div class="col-2"><label class="col-form-label">Cost:&nbsp;($)</label></div>
				<div class="col-4">
					<input class="form-control mt-1" type="number" step="0.01" id="cntnr_cost" name="cntnr_cost" placeholder="0.0" onchange="getNewPrices()">
				</div>
				<div class="col-2"><label class="col-form-label">Surcharges:&nbsp;($)</label></div>
				<div class="col-4">
					<input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_surcharges" name="cntnr_surcharges" placeholder="0.0">
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Discount:&nbsp;(%)</label></div>
				<div class="col-4">
					<input class="form-control mt-1" type="number" step="1" id="cntnr_discount" name="cntnr_discount" placeholder="0" onchange="getNewPrices()">
				</div>
				<div class="col-2"><label class="col-form-label">Tax:&nbsp;(%)</label></div>
				<div class="col-4">
					<input class="form-control mt-1" type="number" step="1" id="cntnr_tax" name="cntnr_tax" placeholder="12" onchange="getNewPrices()">
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Total:&nbsp;($)</label></div>
				<div class="col-4">
					<input class="form-control mt-1" readonly type="number" step="0.01" id="cntnr_total" name="cntnr_total" placeholder="0.0">
				</div>
				<div class="col-2"><label class="col-form-label">Net:&nbsp;($)</label></div>
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
					<input class=form-control mt-1 my-text-height type=date id=cntnr_mt_lfd name=cntnr_mt_lfd>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_seal_no name=cntnr_seal_no>
				</div>
				<div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_cstm_order_no name=cntnr_cstm_order_no>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Booking Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text readonly id=cntnr_job_no name=cntnr_job_no value="{{$cntnr_job_no}}">
				</div>
				<div class="col-2"><button class="btn btn-success my-1 type=button" onclick="AddNewContainer(event)">Add this Container</button></div>
				<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
			</div>
		</div>	
	</div>	
	<div class="card mb-4" id="card_select">
		<div class="card-body">
			<div class="row bg-success text-white fw-bold">
				<div class="col">Container Name</div>
				<div class="col">Steamship Line</div>
				<div class="col">Type</div>
				<div class="col">Length</div>
				<div class="col">Max Load (KGs)</div>
			</div>
		
			<!-- // Body Lines -->
			@foreach ($available_containers as $avlble_container)
			<?php
            $total_containers++;
			array_push($c_names, $avlble_container->id.'_'.$avlble_container->cntnr_name);
			?>
				@if ($total_containers % 2)
					<div class="row" id="{{$avlble_container->id}}" onclick="AddThisSelectedContainer(this.id)" style="background-color:Lavender; cursor: default;">
				@else
					<div class="row" id="{{$avlble_container->id}}" onclick="AddThisSelectedContainer(this.id)" style="background-color:PaleGreen; cursor: default;">
				@endif
					<div class="col">{{$avlble_container->cntnr_name}}</div>
					<div class="col">{{$avlble_container->cntnr_ssl}}</div>
					<div class="col">{{$avlble_container->cntnr_type}}</div>
					<div class="col">{{$avlble_container->cntnr_length}}</div>
					<div class="col">{{$avlble_container->cntnr_max_load}}</div>
				</div>
			@endforeach
			<?php
			if ($total_containers == 0) {
				$c_names[0] = '0_0';
			}
			?>
		</div>
	</div>
@endif
	
<script>
	var cntnr_cost          = 0;
	var cntnr_surcharges    = 0;
	var cntnr_discount      = 0;
	var cntnr_tax           = 0;
	var cntnr_total         = 0;
	var cntnr_net           = 0;
	var rdo_clicked			= 'none';

	if (rdo_clicked == 'none') {
		rdo_clicked = 'create';
		document.getElementById("card_select").style.display = "none";
	}
			
	function RadioCreateClicked() {
		document.getElementById("card_create").style.display = "block";
		document.getElementById("card_select").style.display = "none";
		rdo_clicked = 'create';
	}

	function RadioSelectClicked() {
		document.getElementById("card_create").style.display = "none";
		document.getElementById("card_select").style.display = "block";
		rdo_clicked = 'select';
	}

	function AddThisSelectedContainer(clicked_id) {
		let cNames = {!! json_encode($c_names) !!};
		let cntnrName = '';
		let emptyCList = false;
		for (let idx=0; idx<cNames.length; idx++) {
			if (cNames[idx] == '0_0') {
				emptyCList = true;
			}
			let cntnrNameArray = cNames[idx].split("_");
			if (cntnrNameArray[0] == clicked_id) {
				cntnrName = cntnrNameArray[1];
			}
			document.getElementById(cntnrNameArray[0]).style.backgroundColor="white";
		}

		if (!emptyCList) {
			let oldBgColor = document.getElementById(clicked_id).style.backgroundColor;
			document.getElementById(clicked_id).style.backgroundColor="salmon";

			timer = setTimeout(function(event) { 
				if(!confirm("Are you sure to add the container "+cntnrName+" to the current booking?")) {
					event.preventDefault();
				} else {
					var token = "{{ csrf_token() }}";
					var bookingId = {!! json_encode($booking->id) !!};
					clearTimeout(timer);
					$.ajax({
						url: '/container_add_selected',
						type: 'POST',
						data: {_token:token, bookingId:bookingId, cntnrId:clicked_id},    // the _token:token is for Laravel
						success: function(dataRetFromPHP) {
							location.href = location.href;
							alert("Container (id = "+clicked_id+") is added to booking (id = "+bookingId+") successfully!");
						},
						error: function(err) {
							console.log(err);
							alert(err);
						}
					});
				}
			}, 300, event);        
		}
	}

	function getAllPrices() {
		cntnr_cost = document.getElementById("cntnr_cost").value;
		cntnr_cost = cntnr_cost === ''? document.getElementById("cntnr_cost").placeholder : cntnr_cost;
		cntnr_surcharges = document.getElementById("cntnr_surcharges").value;
		cntnr_surcharges = cntnr_surcharges === ''? document.getElementById("cntnr_surcharges").placeholder : cntnr_surcharges;
		cntnr_discount = document.getElementById("cntnr_discount").value;
		cntnr_discount = cntnr_discount === ''? document.getElementById("cntnr_discount").placeholder/100: cntnr_discount/100;
		cntnr_tax = document.getElementById("cntnr_tax").value;
		cntnr_tax = cntnr_tax === ''? document.getElementById("cntnr_tax").placeholder/100 : cntnr_tax/100;
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
	
	$(document).ready(function() {
		$('.nav-tabs a').on('shown.bs.tab', function(event){		// Lock other tabs except the "Container Details" tab
			var bookingTab = {!! json_encode($booking_tab) !!};
			var id = {!! json_encode($id) !!};

			if (bookingTab == 'containerinfo-tab' && id != '') {
				document.getElementById('bookingdetail-tab').removeAttribute('class');
				document.getElementById('bookingdetail-tab').classList.add('nav-link');
				document.getElementById('containerinfo-tab').removeAttribute('class');
				document.getElementById('containerinfo-tab').classList.add('nav-link');
				document.getElementById('containerinfo-tab').classList.add('active');				// <---- active

				document.getElementById('bookingdetail-tab').setAttribute("aria-checked", false);
				document.getElementById('containerinfo-tab').setAttribute("aria-checked", true);	// <---- active

				document.getElementById('bookingdetail').removeAttribute('class');
				document.getElementById('bookingdetail').classList.add('tab-pane');
				document.getElementById('bookingdetail').classList.add('show');

				document.getElementById('containerinfo').removeAttribute('class');
				document.getElementById('containerinfo').classList.add('tab-pane');
				document.getElementById('containerinfo').classList.add('show');
				document.getElementById('containerinfo').classList.add('fade');						// <---- active
				document.getElementById('containerinfo').classList.add('active');					// <---- active
			}
		});
	});
</script>	

<script>
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
			var cntnr_length = document.getElementById("cntnr_length_li").value;
				cntnr_length = cntnr_length === ''? document.getElementById("cntnr_length_li").placeholder : cntnr_length;
			var cntnr_type = document.getElementById("cntnr_type_li").value;
				cntnr_type = cntnr_type === ''? document.getElementById("cntnr_type_li").placeholder : cntnr_type;
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
				data: {_token:token, cntnr_job_no:cntnr_job_no, cntnr_name:cntnr_name, cntnr_ssl:cntnr_ssl,	cntnr_goods_desc:cntnr_goods_desc, cntnr_length:cntnr_length, cntnr_type:cntnr_type, cntnr_cost:cntnr_cost, cntnr_surcharges:cntnr_surcharges, cntnr_discount:cntnr_discount, cntnr_tax:cntnr_tax, cntnr_total:cntnr_total, cntnr_net:cntnr_net},    // the _token:token is for Laravel
				success: function(dataRetFromPHP) {
					location.href = location.href;
					alert("Container "+cntnr_name+" is added to "+cntnr_job_no+" successfully!");
				},
				error: function(err) {
					console.log(err);
					alert(err);
				}
			});
		}
	}
</script>