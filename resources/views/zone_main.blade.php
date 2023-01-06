@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Zones</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-secondary mr-4" type="button"><a href="{{route('zone_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="zone_search_input">
				  <div class="input-group-append">
					<button class="btn btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_name')\" style=\"cursor: pointer;\">by Zone Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_group')\" style=\"cursor: pointer;\">by Zone Group</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_fsc_deduction')\" style=\"cursor: pointer;\">by Zone FSC Deduction</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$zones = \App\Models\Zone::paginate(10);
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "Zone";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Group";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-5\">";
				$outContents .= "Description";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "FSC Deduction %";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($zones as $zone) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_group;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-5\">";
					$outContents .= "<a href=\zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_description;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_fsc_deduction;
					$outContents .= "</a>";
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $zones->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult1(search_by) {
		zone_search_value = document.getElementById('zone_search_input').value;
		if (zone_search_value) {
			param = search_by + '=' + zone_search_value;
			url = "{{ route('zone_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>