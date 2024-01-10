@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
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

    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Containers</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="container_add">Add</a></button>
			</div>
        </div>
    </div>
	<?php
        use App\Helper\MyHelper;

		// Check if the page is refresed
		$page_no = 1;
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_container'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_container', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'cntnr_name';
				} 
			} else {
				$sortKeyInput = session('sort_key_container', 'cntnr_name');
				$page_no = $_GET['page'];
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_container', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$containers = \App\Models\Container::orderBy($_GET['sort_key_container'], session('sort_order', 'asc'))->where('cntnr_status', '<>', 'deleted')->paginate(10);
			session(['sort_key_container' => $sortKeyInput]);
		} else {
			$containers = \App\Models\Container::orderBy($sortKey, $sortOrder)->where('cntnr_status', '<>', 'deleted')->paginate(10);
		}
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?sort_key_container=cntnr_name&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Name";
				if ($sortKeyInput != 'cntnr_name') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_container=cntnr_type&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Type";
				if ($sortKeyInput != 'cntnr_type') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_container=cntnr_status&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Status";
				if ($sortKeyInput != 'cntnr_status') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?sort_key_container=cntnr_job_no&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Booking";
				if ($sortKeyInput != 'cntnr_job_no') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1 mt-1\">";
				$sortParms = "?sort_key_container=cntnr_length&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Length";
				if ($sortKeyInput != 'cntnr_length') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 mt-1\">";
				$sortParms = "?sort_key_container=cntnr_ssl&sort_time=".time();
				$outContents .= "<a href=\"container_main".$sortParms."\">";
				$outContents .= "Steamship Line";
				if ($sortKeyInput != 'cntnr_ssl') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 mt-1\">";
				$outContents .= "";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($containers as $container) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
					$outContents .= $container->cntnr_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
                    $outContents .= $container->cntnr_type;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
                    $outContents .= $container->cntnr_status;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
                    $outContents .= $container->cntnr_job_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
                    $outContents .= $container->cntnr_length;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
                    if ($container->cntnr_job_no == MyHelper::CntnrNewlyCreated()) {
                        $outContents .= "<a href=\"container_selected?cntnrId=".$container->id."&parentPage=".$page_no."\">";
                    } else {
                        $booking = \App\Models\Booking::where('bk_job_no', $container->cntnr_job_no)->first();
                        $outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'parentPage='.$page_no])."\">";
                    }
                    $outContents .= $container->cntnr_ssl;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
                    if ($container->cntnr_job_no != MyHelper::CntnrNewlyCreated()) {
						$outContents .= "<button class=\"btn btn-secondary btn-sm my-1\" type=\"button\"><a href=\"".route('movements_selected', ['cntnrId'=>$container->id, 'parentPage'=>$page_no])."\">Edit Movements</a></button>";
                    }
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $containers->links(); }}
		{{echo "</row></div>"; }}
	?>
@endsection
