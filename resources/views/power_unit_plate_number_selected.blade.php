@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('power_unit_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	use App\Models\PowerUnit;
	
	$url_components = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url_components['query'], $params);
	$key = array_keys($params)[0];
	$value_parm = $params[$key];
?>

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Power Units Searched Results (by Plate Number)</h2>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="user_search_input">
				  <div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('unit_id')\" style=\"cursor: pointer;\">by Unit Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('plate_number')\" style=\"cursor: pointer;\">by Plate Number</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$units = \App\Models\PowerUnit::where('plate_number', $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$outContents .= "Unit ID";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Make";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Plate Number";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "VIN";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Driver";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Location";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "OPS Code";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Insurance Expiry Date";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($units as $unit) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->unit_id;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->make;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->plate_number;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->vin;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->current_driver;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->current_location;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->ops_code;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->insurance_expiry_date;
					$outContents .= "</a>";
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
	?>
@endsection

<script>
	function GetSearchResult(search_by) {
		unit_search_value = document.getElementById('unit_search_input').value;
		if (unit_search_value) {
			url = '';
			if (search_by == 'unit_id') {
				url = "{{ route('power_unit_id_selected', ':unit_id') }}";
			} else if (search_by == 'plate_number') {
				url = "{{ route('power_unit_plate_number_selected', ':plate_number') }}";
			}
			url = url.replace(':'+search_by, search_by+'='+unit_search_value);
			document.location.href=url;
		}
	}
</script>