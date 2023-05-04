@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('ssl_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$url_components = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url_components['query'], $params);
	$key = array_keys($params)[0];
	$value_parm = $params[$key];
?>

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<?php
					$page_head = "<h2 class=\"text-muted pl-2\">Steamship Line Searched Results</h2>";
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="ssl_search_input">
                  <button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="GetSearchResult('ssl_name')">Search</button>
				</div>			
			</div>
        </div>
    </div>
	<?php
        $ssls = \App\Models\SteamShipLine::where($key, 'LIKE', '%'.$value_parm.'%')->where('deleted', null)->orwhere('deleted', '<>', 'Y')->orderBy('ssl_name', 'asc')->get();

        // Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "SSL Name";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($ssls as $ssl) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
				$outContents .= $ssl->ssl_name;
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
		ssl_search_value = document.getElementById('ssl_search_input').value;
		if (ssl_search_value) {
			param = search_by + '=' + ssl_search_value;
			url = "{{ route('ssl_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>