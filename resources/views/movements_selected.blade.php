@extends('layouts.home_page_base')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
    use App\Models\Booking;
    use App\Models\Container;
    use App\Models\Movement;

	$cntnrId = $_GET['cntnrId'];
    $container = Container::where('id', $cntnrId)->first();
    $booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
?>

@section('goback')
	<a class="text-primary" href="{{route('booking_selected', ['selJobId='.$booking->id])}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Movements of Container <span class="text-primary font-italic">{{$container->cntnr_name}}</span> in Job <span class="text-primary font-italic">{{$container->cntnr_job_no}}</span></h2>
            </div>
        </div>
    </div>
	<?php
		$movs = Movement::where('mvmt_cntnr_name', $container->cntnr_name)->orderBy('mvmt_order')->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
            $outContents .= "<div class=\"col-2\">";
                $outContents .= "Movement Name";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col-2\">";
                $outContents .= "Type";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col-3\">";
				$outContents .= "Company";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "City";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Date/Time";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Live";
			$outContents .= "</div>";
		$outContents .= "</div>";
		{{echo $outContents;}}
		
		// Body Lines
        $total_movs = 0;
        $max_mov_id = 0;
        $all_movements = [];
		foreach ($movs as $mov) {
            $total_movs++;
            array_push($all_movements, $mov->mvmt_name);
            $mvmt_name_array = explode('_', $mov->mvmt_name);
            if ($mvmt_name_array[5] > $max_mov_id) {
                $max_mov_id = $mvmt_name_array[5];
            }

            if ($total_movs % 2) {
                $outContents = "<div class=\"row my-2\" id=\"".$mov->mvmt_name."\" name=\"".$mov->mvmt_name."\" onclick=\"selectThisMov(this)\" oncontextmenu=\"doMenuItemOnThisMovement(this)\" style=\"background-color:Lavender\">";
            } else {
                $outContents = "<div class=\"row my-2\" id=\"".$mov->mvmt_name."\" name=\"".$mov->mvmt_name."\" onclick=\"selectThisMov(this)\" oncontextmenu=\"doMenuItemOnThisMovement(this)\" style=\"background-color:PaleGreen\">";
            }
                $outContents .= "<div class=\"col-2\">";
                    $outContents .= $mov->mvmt_name;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $mov->mvmt_type;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= $mov->mvmt_cmpny_name;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $mov->mvmt_city;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $mov->created_at;
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "&nbsp;";
				$outContents .= "</div>";
			$outContents .= "</div>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
?>

<div class="card my-4" id="#demo1Box" name="#demo1Box">
		<div class="card-body">
			<div class="row">
				<h5 id="sel_mov" name="sel_mov" class="card-title ml-2">Movement Details: </h5>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Work Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=mvmt_operation_date name=mvmt_operation_date>
				</div>
				<div class="col-2"><label class="col-form-label">Work Time:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=time id=mvmt_operation_time_since name=mvmt_operation_time_since>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Reservation No:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_reserv_no name=mvmt_reserv_no>
				</div>
                <div class="col-2"><label class="col-form-label">OPS Code:&nbsp;</label></div>
                <div class="col-4">
                    <?php
                    $tagHead = "<input list=\"mvmt_ops_code\" name=\"mvmt_ops_code\" id=\"bkopscodeinput\" class=\"form-control mt-1 my-text-height\" ";
                    $tagTail = "><datalist id=\"mvmt_ops_code\">";

                    $allTypes = MyHelper::GetAllOpsCodes();
                    foreach($allTypes as $eachType) {
                        $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
                    }
                    $tagTail.= "</datalist>";
                    // if (isset($_GET['selJobId'])) {
                    //     echo $tagHead."placeholder=\"".$booking->bk_ops_code."\" value=\"".$booking->bk_ops_code."\"".$tagTail;
                    // } else {
                        echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                    // }
                    ?>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Company:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_name name=mvmt_cmpny_name>
				</div>
                <div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_address_1 name=mvmt_cmpny_address_1>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">City:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_city name=mvmt_cmpny_city>
				</div>
                <div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_province name=mvmt_cmpny_province>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Post Code:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_postcode name=mvmt_cmpny_postcode>
				</div>
                <div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_country name=mvmt_cmpny_country>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_type name=mvmt_type>
				</div>
                <div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_contact name=mvmt_cmpny_contact>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Telephone:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_tel name=mvmt_cmpny_tel>
				</div>
                <div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_email name=mvmt_cmpny_email>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Description:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_desc name=mvmt_cmpny_desc>
				</div>
                <div class="col-2"><label class="col-form-label">Zone:&nbsp;</label></div>
                <div class="col-4">
                    <input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_zone name=mvmt_cmpny_zone>
                </div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Driver:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=mvmt_cmpny_dvr_no name=mvmt_cmpny_dvr_no>
				</div>
				<div class="col-2"><button class="btn btn-primary my-1 type=button" onclick="UpdateThisMovement(event)">Update</button></div>
				<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
			</div>
		</div>	
	</div>	

@endsection
<style>
    .contextMenu {
        position: absolute;
        width: auto; height: auto;
        color: #b7c4f1;
        background: #344683;
        border: 1px solid #344683;
        display: none;
    }

    .contextMenu dl {
        padding: 0;
        margin: 0;
    }

    .contextMenu dl dt {
        border-bottom: #b7c4f1 1px solid;
        padding: 0;
        margin: 2px 0px;
    }    

    .contextMenu dl dt a {
        text-align: left;
        display: block;
        padding: 5px 10px;
        color: #b7c4f1;
        text-transform: capitalize;
        text-decoration: none;
        font-style: normal;
        font-weight: normal;
    }

    .contextMenu dl dt a:hover {
        background: #2777FF;
    }    
</style>

<script>
    _currentMenuVisible = null;
    var selectedMov = null;
    var totalMovs = {!!json_encode($total_movs)!!}
    var allMovs = {!!json_encode($all_movements)!!};
    var maxMvmtId = {!!json_encode($max_mov_id)!!};
    var prevEl = null;
    var prevTextColor = null;
    var prevElForLeft = null;
    var prevTextColorForLeft = null;

    window.onload = function() {
        for (var mov of allMovs) {
            const el = document.getElementById(mov);
            if (el) {
                el.addEventListener('contextmenu', e => {
                    if (prevEl != null && prevTextColor != null) {
                        prevEl.style.color = prevTextColor; 
                    }
                    prevEl = el;
                    prevTextColor = el.style.color;
                    el.style.color = "Orange"; 
                    e.preventDefault(); 
                    createMenuonRightClick(e.clientX,e.clientY);
                });
            }
        }
        // for (var idx=0; idx<totalMovs; idx++) {
        //     var movRow = 'mov_'+(idx+1);
        //     const el = document.getElementById(movRow);
        //     if (el) {
        //         // el.style.backgroundColor = "lightblue";
        //         // el.addEventListener('click', e => {closetheOpenedMenu()});
        //         el.addEventListener('contextmenu', e => {e.preventDefault(); createMenuonRightClick(e.clientX,e.clientY);});
        //     }
        // }
    }

    document.addEventListener('click', e => {
        if (prevEl != null && prevTextColor != null && prevEl != prevElForLeft) {
            prevEl.style.color = prevTextColor; 
        }
        closetheOpenedMenu();
    });

    // document.addEventListener('contextmenu', e => {
    //     e.preventDefault();
    //     createMenuonRightClick(e.clientX,e.clientY);
    // });

    function closetheOpenedMenu() {
        if (_currentMenuVisible !== null) {
            closeContextMenu(_currentMenuVisible);
        }
    }

    function closeContextMenu(menu) {
        menu.style.left='0px';
        menu.style.top='0px';
        document.body.removeChild(menu);
        _currentMenuVisible = null;
    }

    function createMenuonRightClick(x, y) {
        closetheOpenedMenu();

        const menuElement = document.createElement('div');

        menuElement.classList.add('contextMenu');

        const menuListElement = document.createElement('dl');
        const menuArray = ['Insert Drop Above', 'Insert Drop Below', 'Insert Prepull to HLCS above', 'Insert Prepull to HLCS below', 'Insert Prepull to Chassis Yard above', 'Insert Prepull to Chassis Yard below', 'Insert Dead Run above', 'Insert Dead Run below', 'Delete this Movement'];

        for (var element of menuArray) {
            var listElement = document.createElement('dt');
            listElement.innerHTML = '<a href="#" id="' + element + '" onclick="doThisMenuItem(this);">' + element + '</a>';
            menuListElement.appendChild(listElement);
        }

        menuElement.appendChild(menuListElement);
        document.body.appendChild(menuElement);

        _currentMenuVisible = menuElement;
        menuElement.style.display = 'block';
        menuElement.style.left = x + "px";
        menuElement.style.top = y + "px";
    }

    function doThisMenuItem(el) {
        if((el.innerHTML == 'Delete this Movement') && !confirm("Are you sure to delete this movement?")) {
            event.preventDefault();
        } else {
            var movementName = selectedMov.split("_");
            // alert("User is doing=> " + el.innerHTML + " for movement=> " + movementName[1] + "/" + movementName[3] + "/" + movementName[5]);
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '/movement_ins_or_del',
                type: 'POST',
                data: {_token:token, sel_mvmt_op:el.innerHTML, job_id:movementName[1], cntnr_id:movementName[3], mvmt_id:movementName[5], max_mov_id:maxMvmtId},    // the _token:token is for Laravel
                success: function(dataRetFromPHP) {
                    location.reload();
                    alert("Movement's operation is completed successfully!");
                }
            });
        }
    }

    function selectThisMov(el) {
        if (prevElForLeft != null && prevTextColorForLeft != null) {
            prevElForLeft.style.color = prevTextColorForLeft; 
        }
        prevElForLeft = el;
        prevTextColorForLeft = el.style.color;
        el.style.color = "Orange";
        document.getElementById('sel_mov').innerHTML = 'Movement Details: (for ' + el.id + ')';
    }

    function doMenuItemOnThisMovement(el) {
        selectedMov = el.id;
        // alert("doMenuItemOnThisMovement : " + el.id);
    }
</script>