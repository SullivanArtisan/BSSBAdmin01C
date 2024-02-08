@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Invoices</h2>
            </div>
        </div>
    </div>
	<?php
        use App\Helper\MyHelper;

		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_invoice'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_invoice', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'inv_job_no';
				} 
			} else {
				$sortKeyInput = session('sort_key_invoice', 'inv_job_no');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_invoice', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$invoices = \App\Models\Invoice::orderBy($_GET['sort_key_invoice'], session('sort_order', 'asc'))->where('inv_status', 'invoice_closed')->paginate(10);
			session(['sort_key_invoice' => $sortKeyInput]);
		} else {
			$invoices = \App\Models\Invoice::orderBy($sortKey, $sortOrder)->where('inv_status', 'invoice_closed')->paginate(10);
		}
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?sort_key_invoice=inv_job_no&sort_time=".time();
				$outContents .= "<a href=\"invoice_main".$sortParms."\">";
				$outContents .= "Job No";
				if ($sortKeyInput != 'inv_job_no') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3 mt-1\">";
				$sortParms = "?sort_key_invoice=inv_serial_no&sort_time=".time();
				$outContents .= "<a href=\"invoice_main".$sortParms."\">";
				$outContents .= "<small>Serial No</small>";
				if ($sortKeyInput != 'inv_serial_no') {
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
				$sortParms = "?sort_key_invoice=inv_total&sort_time=".time();
				$outContents .= "<a href=\"invoice_main".$sortParms."\">";
				$outContents .= "Total $";
				if ($sortKeyInput != 'inv_total') {
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
				$sortParms = "?sort_key_invoice=inv_due_date&sort_time=".time();
				$outContents .= "<a href=\"invoice_main".$sortParms."\">";
				$outContents .= "<small>Due Date</small>";
				if ($sortKeyInput != 'inv_due_date') {
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
				$outContents .= "Customer";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($invoices as $invoice) {
            $booking = \App\Models\Booking::where('bk_job_no', $invoice->inv_job_no)->first();
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"invoice_selected?selInvId=$invoice->id\">";
					$outContents .= $invoice->inv_job_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"invoice_selected?selInvId=$invoice->id\">";
					$outContents .= $invoice->inv_serial_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"invoice_selected?selInvId=$invoice->id\">";
					$outContents .= $invoice->inv_total;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"invoice_selected?selInvId=$invoice->id\">";
					$outContents .= $invoice->inv_due_date;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"invoice_selected?selInvId=$invoice->id\">";
					$outContents .= $booking->bk_cstm_account_name;
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
		{{echo  $invoices->links(); }}
		{{echo "</row></div>"; }}
	?>
@endsection
