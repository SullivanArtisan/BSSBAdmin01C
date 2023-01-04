@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Terminals</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-secondary mr-4" type="button"><a href="{{route('terminal_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="trmnl_search_input">
				  <div class="input-group-append">
					<button class="btn btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_name')\" style=\"cursor: pointer;\">by Terminals Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_city')\" style=\"cursor: pointer;\">by City</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_province')\" style=\"cursor: pointer;\">by Province</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_country')\" style=\"cursor: pointer;\">by Country</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_area')\" style=\"cursor: pointer;\">by Area</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$trmnls = \App\Models\Terminal::paginate(10);
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$outContents .= "Terminal";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "City";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Province";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Country";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Area";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($trmnls as $trmnl) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_address;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_city;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_province;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_country;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_area;
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
		{{echo  $trmnls->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult1(search_by) {
		trmnl_search_value = document.getElementById('trmnl_search_input').value;
		if (trmnl_search_value) {
			url = '';
			if (search_by == 'trmnl_name') {
				url = "{{ route('terminal_name_selected', ':trmnl_name') }}";
			} else if (search_by == 'trmnl_city') {
				url = "{{ route('terminal_city_selected', ':trmnl_city') }}";
			} else if (search_by == 'trmnl_province') {
				url = "{{ route('terminal_province_selected', ':trmnl_province') }}";
			} else if (search_by == 'trmnl_country') {
				url = "{{ route('terminal_country_selected', ':trmnl_country') }}";
			} else if (search_by == 'trmnl_area') {
				url = "{{ route('terminal_area_selected', ':trmnl_area') }}";
			}
			url = url.replace(':'+search_by, search_by+'='+trmnl_search_value);
			document.location.href=url;
		}
	}
</script>