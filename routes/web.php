<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PowerUnitController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CstmAccountPriceController;
use App\Http\Controllers\DriverPricesController;
use App\Http\Controllers\ChassisController;
use App\Http\Controllers\SteamShipLineController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PDFController;
use App\Models\User;
use App\Models\UserSysDetail;
use App\Models\PowerUnit;
use App\Models\Zone;
use App\Models\Terminal;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\CstmAccountPrice;
use App\Models\DriverPrices;
use App\Models\Chassis;
use App\Models\SteamShipLine;
use App\Models\Company;
use App\Models\Booking;
use App\Models\Container;
use App\Models\Movement;
use App\Models\Invoice;
use App\Models\ContainerSurcharge;
use App\Models\container_completed;
// use PDF;

function ChangeMovName($job_id, $cntnr_id, $mvmt_id, $include) {
	$pivotMovName = "J_".$job_id."_C_".$cntnr_id."_M_".$mvmt_id;
	$movement = Movement::where('mvmt_name', $pivotMovName)->first();
	$container = Container::where('id', $cntnr_id)->first();

	if ($movement && $container) {
		$movs = Movement::where('mvmt_cntnr_name', $movement->mvmt_cntnr_name)->get();

		foreach($movs as $mov) {
			$mNameArr = explode('_', $mov->mvmt_name);
			if ($mov->mvmt_name > $pivotMovName) {
				$mov->mvmt_name = "J_".$job_id."_C_".$cntnr_id."_M_".($mNameArr[5]+2);
				$mov->mvmt_order = $mNameArr[5]+2;
				$saved = $mov->save();
			}
		}

		if ($include) {
			$movement->mvmt_name = "J_".$job_id."_C_".$cntnr_id."_M_".($mvmt_id+2);
			$movement->mvmt_order = $mvmt_id+2;
			$saved = $movement->save();
		}
	}
}

function InsertThisMovement($sel_mvmt_op, $job_id, $cntnr_id, $mvmt_id, $max_mov_id) {
		$container = Container::where('id', $cntnr_id)->first();
	if ($container) {
		if (str_contains(strtolower($sel_mvmt_op), 'above')) {
			ChangeMovName($job_id, $cntnr_id, $mvmt_id, true);
			$mvmt_name1 = "J_".$job_id."_C_".$cntnr_id."_M_".($mvmt_id);
			$mvmt_name2 = "J_".$job_id."_C_".$cntnr_id."_M_".($mvmt_id+1);
			$mvmt_order1= $mvmt_id;
			$mvmt_order2= $mvmt_id+1;
		} else if (str_contains(strtolower($sel_mvmt_op), 'below')) {
			ChangeMovName($job_id, $cntnr_id, $mvmt_id, false);
			$mvmt_name1 = "J_".$job_id."_C_".$cntnr_id."_M_".($mvmt_id+1);
			$mvmt_name2 = "J_".$job_id."_C_".$cntnr_id."_M_".($mvmt_id+2);
			$mvmt_order1= $mvmt_id+1;
			$mvmt_order2= $mvmt_id+2;
		}

		if (str_contains(strtolower($sel_mvmt_op), 'drop')) {
			$mvmt_cmpny_name = "";
			$mvmt_type1 = "";
			$mvmt_type2 = "";
			$mvmt_cmpny_city = "";
		}  else if (str_contains(strtolower($sel_mvmt_op), 'hlcs')) {
			$mvmt_cmpny_name = "HARBOUR LINK";
			$mvmt_type1 = "PKCS Drop";
			$mvmt_type2 = "PKCS Pickup";
			$mvmt_cmpny_city = "DELTA";
		}  else if (str_contains(strtolower($sel_mvmt_op), 'chassis yard')) {
			$mvmt_cmpny_name = "CHASSIS YARD";
			$mvmt_type1 = "PKCS Drop";
			$mvmt_type2 = "PKCS Pickup";
			$mvmt_cmpny_city = "DELTA";
		}  else if (str_contains(strtolower($sel_mvmt_op), 'dead run')) {
			$mvmt_cmpny_name = "";
			$mvmt_type1 = "Dead Run";
			$mvmt_type2 = "Dead Run";
			$mvmt_cmpny_city = "";
		}

		$movement = new Movement;
		$movement->mvmt_bk_id    = $job_id;
		$movement->mvmt_cntnr_id    = $cntnr_id;
		$movement->mvmt_cntnr_name  = $container->cntnr_name;
		$movement->mvmt_name        = $mvmt_name1;
		$movement->mvmt_order       = $mvmt_order1;
		$movement->mvmt_type        = $mvmt_type1;
		$movement->mvmt_cmpny_name  = $mvmt_cmpny_name;
		$movement->mvmt_cmpny_city  = $mvmt_cmpny_city;
		$saved = $movement->save();

		$movement = new Movement;
		$movement->mvmt_bk_id    = $job_id;
		$movement->mvmt_cntnr_id    = $cntnr_id;
		$movement->mvmt_cntnr_name  = $container->cntnr_name;
		$movement->mvmt_name        = $mvmt_name2;
		$movement->mvmt_order       = $mvmt_order2;
		$movement->mvmt_type        = $mvmt_type2;
		$movement->mvmt_cmpny_name  = $mvmt_cmpny_name;
		$movement->mvmt_cmpny_city  = $mvmt_cmpny_city;
		$saved = $movement->save();
	}
}


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/after_login', function () {
    return view('after_login');
})->middleware(['auth'])->name('after_login');

Route::get('/home_page', function () {
	session_start();
    return view('home_page');
})->middleware(['auth'])->name('home_page');

Route::get('/home_page_old', function () {
    return view('home_page_old');
})->middleware(['auth'])->name('home_page1');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('process_lifetime_expires', function (Request $request) {	
	Session::forget('login_time');
	MyHelper::LogStaffActionResult(Auth::user()->id, 'Automatic logout triggered -- session lifetime expired!', '');
	return;				
})->name('process_lifetime_expires');

//////////////////////////////// For System Users ////////////////////////////////
Route::get('/system_user_main', function () {
    return view('system_user_main');
})->middleware(['auth'])->name('system_user_main');

Route::get('system_user_selected', function (Request $request) {
    return view('system_user_selected');
})->middleware(['auth'])->name('system_user_selected');

Route::get('system_user_condition_selected', function (Request $request) {
    return view('system_user_condition_selected');
})->middleware(['auth'])->name('system_user_condition_selected');

Route::get('/system_user_add', function () {
    return view('system_user_add');
})->middleware(['auth'])->name('system_user_add');

Route::get('/system_user_delete', function () {
	$id = $_GET['id'];
	$user = User::where('id', $id)->first();
	$userName = $user->name;
	$res=UserSysDetail::where('user_id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.user')->with('status', 'The user, <span style="font-weight:bold;font-style:italic;color:red">'.$userName.'</span>, cannot be deleted for some reason.');	
	} else {
		User::where('id', $id)->delete();
		return redirect()->route('op_result.user')->with('status', 'The user, <span style="font-weight:bold;font-style:italic;color:blue">'.$userName.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('system_user_delete');

Route::get('/system_user_pic_upload', function () {
    return view('system_user_pic_upload');
})->middleware(['auth'])->name('system_user_pic_upload');

Route::post('/uploadfile',[FileUploadController::class, 'showUploadFile'])->middleware(['auth'])->name('uploadfile'); 

Route::get('/dev_notes', function () {
    return view('dev_notes');
})->name('dev_notes');

Route::get('sendbasicemail', [MailController::class, 'basic_email']);

Route::get('sendhtmlemail', [MailController::class, 'html_email']);

Route::get('sendattachmentemail', [MailController::class, 'attachment_email']);

//////////////////////////////// For Power Units ////////////////////////////////
Route::get('/power_unit_main', function () {
    return view('power_unit_main');
})->middleware(['auth'])->name('power_unit_main');

Route::get('power_unit_selected', function (Request $request) {
    return view('power_unit_selected');
})->middleware(['auth'])->name('power_unit_selected');

Route::get('power_unit_condition_selected', function (Request $request) {
    return view('power_unit_condition_selected');
})->middleware(['auth'])->name('power_unit_condition_selected');

Route::get('/power_unit_add', function () {
    return view('power_unit_add');
})->middleware(['auth'])->name('power_unit_add');

Route::get('/power_unit_delete', function () {
	$id = $_GET['id'];
	$unit = PowerUnit::where('id', $id)->first();
	$unitPlateNum = $unit->plate_number;
	$res=PowerUnit::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.unit')->with('status', 'The unit, <span style="font-weight:bold;font-style:italic;color:red">'.$unitPlateNum.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.unit')->with('status', 'The unit, <span style="font-weight:bold;font-style:italic;color:blue">'.$unitPlateNum.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('power_unit_delete');

//////////////////////////////// For Zones ////////////////////////////////
Route::get('/zone_main', function () {
    return view('zone_main');
})->middleware(['auth'])->name('zone_main');

Route::get('/zone_add', function () {
    return view('zone_add');
})->middleware(['auth'])->name('zone_add');

Route::get('zone_selected', function (Request $request) {
    return view('zone_selected');
})->middleware(['auth'])->name('zone_selected');

Route::get('zone_condition_selected', function (Request $request) {
    return view('zone_condition_selected');
})->middleware(['auth'])->name('zone_condition_selected');

Route::get('/zone_delete/{id}', function ($id) {
	$zone = Zone::where('id', $id)->first();
	$zoneName = $zone->zone_name;
	$res=Zone::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.zone')->with('status', 'The zone, <span style="font-weight:bold;font-style:italic;color:red">'.$zoneName.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.zone')->with('status', 'The zone, <span style="font-weight:bold;font-style:italic;color:blue">'.$zoneName.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('zone_delete');

//////////////////////////////// For Terminals ////////////////////////////////
Route::get('/terminal_main', function () {
    return view('terminal_main');
})->middleware(['auth'])->name('terminal_main');

Route::get('/terminal_add', function () {
    return view('terminal_add');
})->middleware(['auth'])->name('terminal_add');

Route::get('terminal_selected', function (Request $request) {
    return view('terminal_selected');
})->middleware(['auth'])->name('terminal_selected');

Route::get('terminal_condition_selected', function (Request $request) {
    return view('terminal_condition_selected');
})->middleware(['auth'])->name('terminal_condition_selected');

Route::get('/terminal_delete/{id}', function ($id) {
	$trmnl = Terminal::where('id', $id)->first();
	$trmnlName = $trmnl->trmnl_name;
	$res=Terminal::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.terminal')->with('status', 'The trmnl, <span style="font-weight:bold;font-style:italic;color:red">'.$trmnlName.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.terminal')->with('status', 'The trmnl, <span style="font-weight:bold;font-style:italic;color:blue">'.$trmnlName.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('terminal_delete');

//////////////////////////////// For Customers ////////////////////////////////
Route::get('/customer_main', function () {
    return view('customer_main');
})->middleware(['auth'])->name('customer_main');

Route::get('customer_selected', function (Request $request) {
    return view('customer_selected');
})->middleware(['auth'])->name('customer_selected');

Route::get('customer_condition_selected', function (Request $request) {
    return view('customer_condition_selected');
})->middleware(['auth'])->name('customer_condition_selected');

Route::get('/customer_add', function () {
    return view('customer_add');
})->middleware(['auth'])->name('customer_add');

Route::get('/customer_delete/{id}', function ($id) {
	$customer = Customer::where('id', $id)->first();
	$customerName = $customer->cstm_account_name;
	$res=Customer::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.customer')->with('status', 'The customer, <span style="font-weight:bold;font-style:italic;color:red">'.$customerName.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.customer')->with('status', 'The customer, <span style="font-weight:bold;font-style:italic;color:blue">'.$customerName.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('customer_delete');

Route::get('/customer_accprice_delete/{id}', function ($id) {
	$customer_accprice = CstmAccountPrice::where('id', $id)->first();
	$priceFromZone = $customer_accprice->cstm_account_from;
	$priceToZone = $customer_accprice->cstm_account_to;
	$res=CstmAccountPrice::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.customer')->with('status', 'The price, zone <span style="font-weight:bold;font-style:italic;color:red">'.$priceFromZone.' &#x27A1; '.$priceToZone.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.customer')->with('status', 'The price, zone <span style="font-weight:bold;font-style:italic;color:blue">'.$priceFromZone.' &#x27A1; '.$priceToZone.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('customer_accprice_delete');

Route::post('/customer_accprice_result', [CstmAccountPriceController::class, 'store'])->name('customer_accprice_add');
Route::post('/customer_update2', function () {
	route('customer_accprice_add');
})->name('customer_update2');

Route::get('customer_accprice_selected_main', function (Request $request) {
    return view('customer_accprice_selected_main');
})->middleware(['auth'])->name('customer_accprice_selected_main');

Route::get('/customer_accprice_add', function () {
	$id = $_GET['id'];
	if ($id) {
		return view('customer_accprice_add')->withOprand($id);
	}
})->middleware(['auth'])->name('customer_accprice_add');

Route::post('/customer_accprice_update', [CstmAccountPriceController::class, 'update'])->name('customer_accprice_update');

//////////////////////////////// For Drivers ////////////////////////////////
Route::get('/driver_main', function () {
    return view('driver_main');
})->middleware(['auth'])->name('driver_main');

Route::get('driver_selected', function (Request $request) {
    return view('driver_selected');
})->middleware(['auth'])->name('driver_selected');

Route::get('driver_condition_selected', function (Request $request) {
    return view('driver_condition_selected');
})->middleware(['auth'])->name('driver_condition_selected');

Route::get('/driver_add', function () {
    return view('driver_add');
})->middleware(['auth'])->name('driver_add');

Route::get('/driver_delete/{id}', function ($id) {
	$driver = Driver::where('id', $id)->first();
	$driverName = $driver->dvr_name;
	$driver->dvr_deleted = 'Y';
	$res = $driver->save();
					
	if(!$res) {
		return redirect()->route('op_result.driver')->with('status', ' <span style="color:red">Failed to delete driver '.$driverName.'!</span>');
	} else {
		return redirect()->route('op_result.driver')->with('status', 'The driver,  <span style="font-weight:bold;font-style:italic;color:blue">'.$driverName.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('driver_delete');

//////////////////////////////// For Bookings ////////////////////////////////
Route::get('/booking_main', function () {
    return view('booking_main');
})->middleware(['auth'])->name('booking_main');

Route::get('booking_selected', function (Request $request) {
    return view('booking_selected');
})->middleware(['auth'])->name('booking_selected');

Route::get('/booking_add', function () {
    return view('booking_add');
})->middleware(['auth'])->name('booking_add');

Route::get('/booking_delete/{id}', function ($id) {
	$booking = Booking::where('id', $id)->first();
	$bkJobNo = $booking->bk_job_no;
	$booking->bk_status = 'deleted';
	$res = $booking->save();
					
	if(!$res) {
		return redirect()->route('op_result.booking')->with('status', ' <span style="color:red">Failed to delete booking job '.$bkJobNo.'!</span>');
	} else {
		return redirect()->route('op_result.booking', ['id'=>$id])->with('status', 'The booking job,  <span style="font-weight:bold;font-style:italic;color:blue">'.$bkJobNo.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('booking_delete');

Route::post('/booking_pay_off', function (Request $request) {
	$booking = Booking::where('id', $_POST['booking_id'])->first();
	MyHelper::LogStaffAction(Auth::user()->id, 'To pay off booking '.$booking->bk_job_no.'.', '');
	$booking->bk_status = MyHelper::BkFullyPaidStaus();
	$res = $booking->save();
					
	if(!$res) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as bk_status cannot be updated.', '');
	} else {
		$containers = Container::where('cntnr_job_no', $booking->bk_job_no)->get();
		foreach ($containers as $container) {
			if ($container->cntnr_status == MyHelper::CntnrCompletedStaus()) {
				$paid_price = $container->cntnr_net;
				$res = ContainerController::ResetContainer($container);

				if(!$res) {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as container cannot be reset.', '');
				} else {
					$completed_cntnr = container_completed::where('ccntnr_id', $container->id)->where('ccntnr_job_id', $booking->id)->first();

					if ($completed_cntnr) {
						$completed_cntnr->ccntnr_status	= MyHelper::CntnrCompletedStaus();
						$completed_cntnr->ccntnr_paid 	= $paid_price;
						$res = $completed_cntnr->save();

						if(!$res) {
							MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as ccntnr_paid cannot be updated.', '');
						} else {

							$invoice = Invoice::where('inv_job_no', $booking->bk_job_no)->first();

							if ($invoice) {
								$invoice->inv_paid = $paid_price;
								$invoice->inv_status = MyHelper::InvoiceClosedStaus();
								$res = $invoice->save();
		
								if(!$res) {
									MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as inv_status cannot be updated.', '');
								} else {
									MyHelper::LogStaffActionResult(Auth::user()->id, 'Paid off booking '.$booking->bk_job_no.' OK.', '');
								}
							} else {
								MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as the invoice cannot be accessed.', '');
							}
						}
					} else {
						MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to pay off booking '.$booking->bk_job_no.' as the completed_container cannot be accessed.', '');
					}
				}
			} else {
				Log::Info('Weird! The container '.$container->id.' status should be completed, but it\'s not!');
			}
		}
	}
})->middleware(['auth'])->name('booking_pay_off');

Route::post('/send_invoice_to_customer', function (Request $request) {
	$booking = Booking::where('id', $_POST['booking_id'])->first();
	$containers = Container::where('cntnr_job_no', $booking->bk_job_no)->get();
	$net_price  = 0;
	foreach ($containers as $container) {
		if ($container->cntnr_status != 'deleted') {
			$net_price += $container->cntnr_net;
		}
	}
	MyHelper::LogStaffAction(Auth::user()->id, 'To send invoice of booking '.$booking->bk_job_no.'.', '');

	$just_resend_email = false;
	$current_seconds = time();
	$due_date_seconds = $current_seconds + MyHelper::$invPaymentWaitingPeriod * 24 * 60 * 60;
	$invoice = Invoice::where('inv_job_no', $booking->bk_job_no)->first();
	if ($invoice && $invoice->inv_status != 'deleted' && $invoice->inv_status != MyHelper::InvoiceCancelledStaus()) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Invoice '.$invoice->inv_serial_no.' already existed. Just send it to the customer again.', '');
		$res = true;
		$just_resend_email = true;
	} else { 
		$inv_serial_no = date("Y-m-d-", $current_seconds).$booking->bk_job_no;
		$booking->bk_status 		= MyHelper::BkInvoicedStaus();
		$booking->bk_inv_serial_no	= $inv_serial_no;
		if (!$booking->save()) {
			Log::Info('Oops, something to change bk_status to invoiced for booking '.$booking->bk_job_no);
		}

		$invoice = new Invoice;
		$invoice->inv_serial_no   	= $inv_serial_no;
		$invoice->inv_job_no      	= $booking->bk_job_no;
		$invoice->inv_total    		= $net_price;
		$invoice->inv_status       	= MyHelper::InvoiceIssuedStaus();
		$invoice->inv_issued_date	= date("Y-m-d H:i:s", $current_seconds);
		$invoice->inv_due_date    	= date("Y-m-d H:i:s", $due_date_seconds);
		$res = $invoice->save();
	}
					
	if(!$res) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to create invoice record: '.$invoice->inv_serial_no.' for booking '.$booking->bk_job_no.'.', '');
	} else {
		$invoice_file_name = $invoice->inv_serial_no.'.pdf';
		if ($just_resend_email) {
			$result = true;
		} else {
			$result = PDFController::sendInvoice($booking, $invoice_file_name);
		}

		if (!$result) {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to create a invoice PDF file '.$invoice_file_name.' for booking '.$booking->bk_job_no.'.', '');
		} else {
			$customer = Customer::where('cstm_account_no', $booking->bk_cstm_account_no)->first();
			if ($customer == null) {
				MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to send the invoice PDF file '.$invoice_file_name.' for booking '.$booking->bk_job_no.'.', '');
			} else {
				$rec_email	= $customer->cstm_contact_email1;
				$rec_name 	= $customer->cstm_contact_name1;
				$subject 	= "The invoice (for job ".$booking->bk_job_no.") is ready for you!";
				$body 	 	= "Hi ".$rec_name.",\r\n\r\nThe invoice ".$invoice_file_name." is ready for your attention and process. Please pay it off before the due date.\r\n\r\n";
				MyHelper::SendThisEmail($rec_email, $rec_name, $subject, $body, $invoice_file_name);
			}
		}

		MyHelper::LogStaffActionResult(Auth::user()->id, 'Sent invoice '.$invoice->inv_serial_no.' for booking '.$booking->bk_job_no.' OK.', '');
	}
})->middleware(['auth'])->name('send_invoice_to_customer');

//////////////////////////////// For Invoice ////////////////////////////////
Route::get('/invoice_main', function () {
	return view('invoice_main');
	})->middleware(['auth'])->name('invoice_main');

Route::get('/invoice_selected', function () {
	return view('invoice_selected');
	})->middleware(['auth'])->name('invoice_selected');

//////////////////////////////// For Dispatch ////////////////////////////////
Route::get('/dispatch_main', function () {
	return view('dispatch_main');
	})->middleware(['auth'])->name('dispatch_main');

Route::get('/dispatch_container', function () {
	if (!isset($_GET['driverId'])) {
		return view('dispatch_container');
	} else {
		$cntnrId = $_GET['cntnrId'];
		$driverId = $_GET['driverId'];
        $container = Container::where('id', $cntnrId)->first();
        $driver = Driver::where('id', $driverId)->first();
		$result = ContainerController::AssignContainerToDriver($driverId, $cntnrId);
		if(!$result) {
			return redirect()->route('op_result.dispatch')->with('status', ' <span style="color:red">Container has NOT been dipatched!</span>');
		} else {
			$rec_email	= $driver->dvr_email;
			$rec_name 	= $driver->dvr_name;
			$subject 	= "A container job (of ".$container->cntnr_name.") is ready for you!";
			$body 	 	= "Hi ".$rec_name.",\r\n\r\nThe container ".$container->cntnr_name." is ready for your attention and operation. Please click http://bssbadmin01c.test/ContainerJob4Driver?driverId=".$driverId."&cntnrId=".$cntnrId." for the details.\r\n\r\n";
			MyHelper::SendThisEmail($rec_email, $rec_name, $subject, $body, '');
            return redirect()->route('op_result.dispatch', ['cntnrId'=>$cntnrId])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been dipatched to the driver '.$driver->dvr_no.' successfully.');
        }
	}
})->middleware(['auth'])->name('dispatch_container');

//////////////////////////////// For Containers ////////////////////////////////
// Although the 'add' function is triggered by the Ajax function directly of the "Add this Container" button instead of the normal form's POST method through web.php's route,
// we STILL need the route for the "add" operation. DON'T KNOW WHY!!
Route::get('/container_main', function () {
    return view('container_main');
})->middleware(['auth'])->name('container_main');

Route::get('/container_add', function () {
    return view('container_add');
})->middleware(['auth'])->name('container_add');

Route::post('container_add_new', [ContainerController::class, 'add'])->middleware(['auth'])->name('container_add_new');
Route::post('container_add_selected', [ContainerController::class, 'addSelected'])->middleware(['auth'])->name('container_add_selected');

Route::get('container_selected', function (Request $request) {
    return view('container_selected');
})->middleware(['auth'])->name('container_selected');

Route::get('container_completed_selected', function (Request $request) {
    return view('container_completed_selected');
})->middleware(['auth'])->name('container_completed_selected');

Route::get('container_to_dispatch/{cntnrId}', function ($cntnrId) {
	$container = Container::where('id', $cntnrId)->first();
	$booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
	$containerName = $container->cntnr_name;
	$container->cntnr_status = MyHelper::CntnrSentStaus();
	$res = $container->save();
					
	if(!$res) {
		return redirect()->route('op_result.container')->with('status', ' <span style="color:red">Failed to send container '.$containerName.' to dispatch!</span>');
	} else {
		ContainerController::UpdateBookingStatus($booking);
		return redirect()->route('op_result.container', ['id'=>$booking->id, 'prevPage'=>"unknown", 'selJobId'=>$booking->id])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$containerName.'</span>, has been sent to dispatch successfully.');
	}
})->middleware(['auth'])->name('container_to_dispatch');

Route::get('/container_delete/{id}', function ($id) {
	$container = Container::where('id', $id)->first();
	MyHelper::LogStaffAction(Auth::user()->id, 'To delete the container '.$container->cntnr_name.'.', '');
	$containerName = $container->cntnr_name;
	$container->cntnr_status = 'deleted';
	$res = $container->save();
					
	if(!$res) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to delete the container '.$containerName.'.', '');
		return redirect()->route('op_result.container')->with('status', ' <span style="color:red">Failed to delete container '.$containerName.'!</span>');
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted the container '.$containerName.' OK.', '');
		return redirect()->route('op_result.container', ['id'=>$id, 'prevPage'=>"unknown", 'selJobId'=>0])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$containerName.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('container_delete');

Route::get('/container_remove/{id}', function ($id) {
	$container = Container::where('id', $id)->first();
	$containerName = $container->cntnr_name;
	$oldjobName = $container->cntnr_job_no;
	MyHelper::LogStaffAction(Auth::user()->id, 'To remove the container '.$containerName.' from the booking '.$oldjobName.'.', '');
	$booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
	$res = ContainerController::ResetContainer($container);
					
	if(!$res) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to remove the container '.$containerName.' from the booking '.$oldjobName.'.', '');
		return redirect()->route('op_result.container')->with('status', ' <span style="color:red">Failed to remove container '.$containerName.'!</span>');
	} else {
		if ($booking) {
			$totalContainers = $booking->bk_total_containers;
			$booking->bk_total_containers = --$totalContainers;
			$saved = $booking->save();

			ContainerController::UpdateBookingStatus($booking);

			// delete the related movements
			$movements = Movement::where('mvmt_cntnr_name', $containerName)->where('mvmt_bk_id', $booking->id)->get();
			foreach($movements as $movement) {
				if (!$movement->delete()) {
					Log::Info('Oops, failed to delete the related movement of container '.$containerName.' in booking '.$booking->id);
				}
			}

			// delete the related surcharges
			$surcharges = ContainerSurcharge::where('cntnrsurchrg_cntnr_id', $id)->where('cntnrsurchrg_job_no', $booking->bk_job_no)->get();
			foreach($surcharges as $surcharge) {
				if (!$surcharge->delete()) {
					Log::Info('Oops, failed to delete the related surcharge of container '.$containerName.' in booking '.$booking->id);
				}
			}

			MyHelper::LogStaffActionResult(Auth::user()->id, 'Removed the container '.$containerName.' from the booking '.$oldjobName.' OK.', '');
			return redirect()->route('op_result.container', ['id'=>$id, 'prevPage'=>"unknown", 'selJobId'=>$booking->id])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$containerName.'</span>, has been deleted successfully.');
		} else {
			Log::Info('Oops, cannot get the booking while remove the container '.$containerName.' from the booking '.$oldjobName.'.');
			return redirect()->route('op_result.container', ['id'=>$id, 'prevPage'=>"unknown", 'selJobId'=>0])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$containerName.'</span>, has been deleted successfully.');
		}
	}
})->middleware(['auth'])->name('container_remove');

Route::get('/container_charges_main', function () {
    return view('container_charges_main');
})->middleware(['auth'])->name('container_charges_main');

Route::get('/container_completed_charges_main', function () {
    return view('container_completed_charges_main');
})->middleware(['auth'])->name('container_completed_charges_main');

Route::post('/container_surcharge_add', function (Request $request) {
	$container = Container::where('id', $_POST['cntnrsurchrg_cntnr_id'])->first();
	MyHelper::LogStaffAction(Auth::user()->id, 'To add a surcharge of $'.$_POST['cntnrsurchrg_charge'].' for container '.$container->cntnr_name.'.', '');
	$cntnr_surcharge = new ContainerSurcharge;
	if ($cntnr_surcharge) {
		$cntnr_surcharge->cntnrsurchrg_cntnr_id 		= $_POST['cntnrsurchrg_cntnr_id'];
		$cntnr_surcharge->cntnrsurchrg_type 			= $_POST['cntnrsurchrg_type'];
		$cntnr_surcharge->cntnrsurchrg_desc 			= $_POST['cntnrsurchrg_desc'];
		$cntnr_surcharge->cntnrsurchrg_3rd_pty_inv_no	= $_POST['cntnrsurchrg_3rd_pty_inv_no'];
		$cntnr_surcharge->cntnrsurchrg_quantity 		= $_POST['cntnrsurchrg_quantity'];
		$cntnr_surcharge->cntnrsurchrg_rate 			= $_POST['cntnrsurchrg_rate'];
		$cntnr_surcharge->cntnrsurchrg_charge 			= $_POST['cntnrsurchrg_charge'];
		$cntnr_surcharge->cntnrsurchrg_override 		= $_POST['cntnrsurchrg_override'];
		$cntnr_surcharge->cntnrsurchrg_job_no 			= $_POST['cntnrsurchrg_job_no'];
	}
	if(strlen($cntnr_surcharge->cntnrsurchrg_quantity)==0)
		{$cntnr_surcharge->cntnrsurchrg_quantity = 0;}
	if(strlen($cntnr_surcharge->cntnrsurchrg_rate)==0)
		{$cntnr_surcharge->cntnrsurchrg_rate = 0;}
	if(strlen($cntnr_surcharge->cntnrsurchrg_charge)==0)
		{$cntnr_surcharge->cntnrsurchrg_charge = 0;}

	$saved = $cntnr_surcharge->save();
	if (!$saved) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to add a surcharge for container '.$container->cntnr_name.'.', '');
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Added the surcharge '.$cntnr_surcharge->id.' OK.', '');
		$container = Container::where('id', $_POST['cntnrsurchrg_cntnr_id'])->first();
		$container->cntnr_surcharges	+= $cntnr_surcharge->cntnrsurchrg_charge;
		$container->cntnr_total 		= ($container->cntnr_cost + $container->cntnr_surcharges) * (1 + $container->cntnr_tax);
		$container->cntnr_net 			= $container->cntnr_total - $container->cntnr_discount;
		$saved = $container->save();
		if (!$saved) {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to update the surcharge for container '.$container->cntnr_name.'.', '');
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated the cntnr_surcharges OK for container'.$container->cntnr_name.'.', '');
		}
	}
})->middleware(['auth'])->name('container_surcharge_add');

Route::post('/container_surcharge_update', function (Request $request) {
	$container = Container::where('id', $_POST['cntnrsurchrg_cntnr_id'])->first();
	$cntnr_surcharge = ContainerSurcharge::where('id', $_POST['cntnrsurchrg_id'])->first();
	MyHelper::LogStaffAction(Auth::user()->id, 'To update the surcharge '.$_POST['cntnrsurchrg_id'].' for container '.$container->cntnr_name.'.', '');
	$oldSurcharge = 0;
	if ($cntnr_surcharge) {
		$cntnr_surcharge->cntnrsurchrg_cntnr_id 		= $_POST['cntnrsurchrg_cntnr_id'];
		$cntnr_surcharge->cntnrsurchrg_type 			= $_POST['cntnrsurchrg_type'];
		$cntnr_surcharge->cntnrsurchrg_desc 			= $_POST['cntnrsurchrg_desc'];
		$cntnr_surcharge->cntnrsurchrg_3rd_pty_inv_no	= $_POST['cntnrsurchrg_3rd_pty_inv_no'];
		$cntnr_surcharge->cntnrsurchrg_quantity 		= $_POST['cntnrsurchrg_quantity'];
		$cntnr_surcharge->cntnrsurchrg_rate 			= $_POST['cntnrsurchrg_rate'];
		$oldSurcharge = $cntnr_surcharge->cntnrsurchrg_charge;
		$cntnr_surcharge->cntnrsurchrg_charge 			= $_POST['cntnrsurchrg_charge'];
		$cntnr_surcharge->cntnrsurchrg_override 		= $_POST['cntnrsurchrg_override'];
	}
	if(strlen($cntnr_surcharge->cntnrsurchrg_quantity)==0)
		{$cntnr_surcharge->cntnrsurchrg_quantity = 0;}
	if(strlen($cntnr_surcharge->cntnrsurchrg_rate)==0)
		{$cntnr_surcharge->cntnrsurchrg_rate = 0;}
	if(strlen($cntnr_surcharge->cntnrsurchrg_charge)==0)
		{$cntnr_surcharge->cntnrsurchrg_charge = 0;}

	$saved = $cntnr_surcharge->save();
	if (!$saved) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to update the surcharge '.$_POST['cntnrsurchrg_id'].'.', '');
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated the surcharge '.$_POST['cntnrsurchrg_id'].' OK.', '');
		$container = Container::where('id', $_POST['cntnrsurchrg_cntnr_id'])->first();
		$container->cntnr_surcharges	= $container->cntnr_surcharges - $oldSurcharge + $cntnr_surcharge->cntnrsurchrg_charge;
		$container->cntnr_total 		= ($container->cntnr_cost + $container->cntnr_surcharges) * (1 + $container->cntnr_tax);
		$container->cntnr_net 			= $container->cntnr_total - $container->cntnr_discount;
		$saved = $container->save();
		if (!$saved) {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to update the cntnr_surcharges for container '.$container->cntnr_name.'.', '');
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated the cntnr_surcharges OK for container'.$container->cntnr_name.'. ($oldSurcharge='.$oldSurcharge.';$$cntnr_surcharge->cntnrsurchrg_charge='.$cntnr_surcharge->cntnrsurchrg_charge.')', '');
		}
	}
})->middleware(['auth'])->name('container_surcharge_update');


Route::post('/container_surcharge_delete', function (Request $request) {
	$cntnr_surcharge = ContainerSurcharge::where('id', $_POST['cntnrsurchrg_id'])->first();
	$container = Container::where('id', $cntnr_surcharge->cntnrsurchrg_cntnr_id)->first();
	$oldSurcharge = $cntnr_surcharge->cntnrsurchrg_charge;
	MyHelper::LogStaffAction(Auth::user()->id, 'To delete the surcharge '.$_POST['cntnrsurchrg_id'].' for container '.$container->cntnr_name.'.', '');
	
	$deleted = ContainerSurcharge::where('id', $_POST['cntnrsurchrg_id'])->delete();
	if (!$deleted) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to delete the surcharge '.$_POST['cntnrsurchrg_id'].'.', '');
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted the surcharge '.$_POST['cntnrsurchrg_id'].' OK.', '');
		$container->cntnr_surcharges	= $container->cntnr_surcharges - $oldSurcharge;
		$container->cntnr_total 		= ($container->cntnr_cost + $container->cntnr_surcharges) * (1 + $container->cntnr_tax);
		$container->cntnr_net 			= $container->cntnr_total - $container->cntnr_discount;
		$saved = $container->save();
		if (!$saved) {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to delete the cntnr_surcharges for container '.$container->cntnr_name.'.', '');
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted the cntnr_surcharges OK for container'.$container->cntnr_name.'.', '');
		}
	}
})->middleware(['auth'])->name('container_surcharge_delete');

Route::get('/ContainerAddedToBooking', function () {
	$cntnr_id 	  = $_GET['cntnrId'];
	$booking_name = $_GET['bkName'];
	ContainerController::AddContainerToBooking($booking_name, $cntnr_id);
	$booking = Booking::where('bk_job_no', $booking_name)->first();
	return redirect()->route('container_selected', ['cntnrId='.$cntnr_id, 'cntnrJobNo='.$booking_name, 'prevPage=booking_selected', 'selJobId='.$booking->id]);
})->middleware(['auth'])->name('ContainerAddedToBooking');

//////////////////////////////// For Movements ////////////////////////////////
Route::get('/movements_selected', function () {
    return view('movements_selected');
})->middleware(['auth'])->name('movements_selected');

Route::post('/movement_update', function (Request $request) {
	$mov = Movement::where('mvmt_name', $_POST['mvmt_name'])->first();
	if ($mov) {
		MyHelper::LogStaffAction(Auth::user()->id, 'Updated movement '.$mov->id.' ('.$mov->mvmt_name.') of container '.$mov->mvmt_cntnr_name.' for booking '.$mov->mvmt_bk_id.'.', '');

		if (strlen($_POST['mvmt_operation_date']) > 0) {
			$mov->mvmt_operation_date 		= $_POST['mvmt_operation_date'];
		}
		$mov->mvmt_operation_time_since	= $_POST['mvmt_operation_time_since'];
		$mov->mvmt_reserv_no 			= $_POST['mvmt_reserv_no'];
		$mov->mvmt_ops_code 			= $_POST['mvmt_ops_code'];
		$mov->mvmt_cmpny_name 			= $_POST['mvmt_cmpny_name'];
		$mov->mvmt_cmpny_address_1 		= $_POST['mvmt_cmpny_address_1'];
		$mov->mvmt_cmpny_city 			= $_POST['mvmt_cmpny_city'];
		$mov->mvmt_cmpny_province 		= $_POST['mvmt_cmpny_province'];
		$mov->mvmt_cmpny_postcode 		= $_POST['mvmt_cmpny_postcode'];
		$mov->mvmt_cmpny_country 		= $_POST['mvmt_cmpny_country'];
		$mov->mvmt_type 				= $_POST['mvmt_type'];
		$mov->mvmt_cmpny_contact 		= $_POST['mvmt_cmpny_contact'];
		$mov->mvmt_cmpny_tel 			= $_POST['mvmt_cmpny_tel'];
		$mov->mvmt_cmpny_email 			= $_POST['mvmt_cmpny_email'];
		$mov->mvmt_cmpny_desc 			= $_POST['mvmt_cmpny_desc'];
		$mov->mvmt_cmpny_zone 			= $_POST['mvmt_cmpny_zone'];
		$mov->mvmt_cmpny_dvr_no 		= $_POST['mvmt_cmpny_dvr_no'];

		$result = $mov->save();
		if(!$result) {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to update movement '.$mov->id.' ('.$mov->mvmt_name.') of container '.$mov->mvmt_cntnr_name.'.', '');
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated movement '.$mov->id.' ('.$mov->mvmt_name.') of container '.$mov->mvmt_cntnr_name.' OK.', '');
		}
	}

    return redirect()->back();
})->middleware(['auth'])->name('movement_update');

Route::post('/movement_ins_or_del', function (Request $request) {
	$sel_mvmt_op = $_POST['sel_mvmt_op'];
	$job_id = $_POST['job_id'];
	$cntnr_id = $_POST['cntnr_id'];
	$mvmt_id = $_POST['mvmt_id'];
	$max_mov_id = $_POST['max_mov_id'];
	if (str_contains(strtolower($sel_mvmt_op), 'insert')) {
		InsertThisMovement($sel_mvmt_op, $job_id, $cntnr_id, $mvmt_id, $max_mov_id);
	}
	if (str_contains(strtolower($sel_mvmt_op), 'delete')) {
		$res=Movement::where('mvmt_name', "J_".$job_id."_C_".$cntnr_id."_M_".$mvmt_id)->delete();
	}
})->middleware(['auth'])->name('movement_ins_or_del');

//////////////////////////////// For Driver Pay Prices ////////////////////////////////
Route::get('/driver_pay_prices_main', function () {
    return view('driver_pay_prices_main');
})->middleware(['auth'])->name('driver_pay_prices_main');

Route::get('/driver_pay_prices_add', function () {
    return view('driver_pay_prices_add');
})->middleware(['auth'])->name('driver_pay_prices_add');

Route::get('driver_pay_prices_selected', function (Request $request) {
    return view('driver_pay_prices_selected');
})->middleware(['auth'])->name('driver_pay_prices_selected');

Route::get('driver_pay_prices_condition_selected', function (Request $request) {
    return view('driver_pay_prices_condition_selected');
})->middleware(['auth'])->name('driver_pay_prices_condition_selected');

Route::get('/driver_pay_prices_delete/{id}', function ($id) {
	$driver_price = DriverPrices::where('id', $id)->first();
	$zoneFrom = $driver_price->drvr_pay_price_zone_from;
	$zoneTo = $driver_price->drvr_pay_price_zone_to;
	$res=DriverPrices::where('id', $id)->delete();
	if (!$res) {
		return redirect()->route('op_result.driver_price')->with('status', 'The driver price, <span style="font-weight:bold;font-style:italic;color:red">'.$zoneFrom.' &#x27A1; '.$zoneTo.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.driver_price')->with('status', 'The driver price, <span style="font-weight:bold;font-style:italic;color:blue">'.$zoneFrom.' &#x27A1; '.$zoneTo.'</span>, has been deleted successfully.');	
	}
})->middleware(['auth'])->name('driver_pay_prices_delete');

//////////////////////////////// For Chassis ////////////////////////////////
Route::get('/chassis_main', function () {
    return view('chassis_main');
})->middleware(['auth'])->name('chassis_main');

Route::get('/chassis_add', function () {
    return view('chassis_add');
})->middleware(['auth'])->name('chassis_add');

Route::get('chassis_selected', function (Request $request) {
    return view('chassis_selected');
})->middleware(['auth'])->name('chassis_selected');

Route::get('chassis_condition_selected', function (Request $request) {
    return view('chassis_condition_selected');
})->middleware(['auth'])->name('chassis_condition_selected');

Route::get('/chassis_delete/{id}', function ($id) {
	$chassis = Chassis::where('id', $id)->first();
	$chassisNumber = $chassis->code;
	$chassis->deleted = 'Y';
	$res = $chassis->save();
					
	if(!$res) {
		return redirect()->route('op_result.chassis')->with('status', ' <span style="color:red">Failed to delete chassis '.$chassisNumber.'!</span>');
	} else {
		return redirect()->route('op_result.chassis')->with('status', 'The chassis,  <span style="font-weight:bold;font-style:italic;color:blue">'.$chassisNumber.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('chassis_delete');

//////////////////////////////// For Steamship Lines ////////////////////////////////
Route::get('/ssl_main', function () {
    return view('ssl_main');
})->middleware(['auth'])->name('ssl_main');

Route::get('/ssl_add', function () {
    return view('ssl_add');
})->middleware(['auth'])->name('ssl_add');

Route::get('ssl_selected', function (Request $request) {
    return view('ssl_selected');
})->middleware(['auth'])->name('ssl_selected');

Route::get('ssl_condition_selected', function (Request $request) {
    return view('ssl_condition_selected');
})->middleware(['auth'])->name('ssl_condition_selected');

Route::get('/ssl_delete/{id}', function ($id) {
	$ssl = SteamShipLine::where('id', $id)->first();
	$ssl_name = $ssl->ssl_name;
	$ssl->deleted = 'Y';
	$res = $ssl->save();
					
	if(!$res) {
		return redirect()->route('op_result.ssl')->with('status', ' <span style="color:red">Failed to delete ssl '.$ssl_name.'!</span>');
	} else {
		return redirect()->route('op_result.ssl')->with('status', 'The ssl,  <span style="font-weight:bold;font-style:italic;color:blue">'.$ssl_name.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('ssl_delete');

//////////////////////////////// For Companies Addresses ////////////////////////////////
Route::get('/company_main', function () {
    return view('company_main');
})->middleware(['auth'])->name('company_main');

Route::get('/company_add', function () {
    return view('company_add');
})->middleware(['auth'])->name('company_add');

Route::get('company_selected', function (Request $request) {
    return view('company_selected');
})->middleware(['auth'])->name('company_selected');

Route::get('company_condition_selected', function (Request $request) {
    return view('company_condition_selected');
})->middleware(['auth'])->name('company_condition_selected');

Route::get('/company_delete/{id}', function ($id) {
	$company = Company::where('id', $id)->first();
	$company_name = $company->cmpny_name;
	$company->cmpny_deleted = 'Y';
	$res = $company->save();
					
	if(!$res) {
		return redirect()->route('op_result.company')->with('status', ' <span style="color:red">Failed to delete company '.$company_name.'!</span>');
	} else {
		return redirect()->route('op_result.company')->with('status', 'The company,  <span style="font-weight:bold;font-style:italic;color:blue">'.$company_name.'</span>, has been deleted successfully.');
	}
})->middleware(['auth'])->name('company_delete');

//////////////////////////////// For Misc. ////////////////////////////////
Route::get('/generate_pdf', [PDFController::class, 'generatePDF'])->middleware(['auth'])->name('generate_pdf');


//////////////////////////////// For All Results ////////////////////////////////
Route::name('op_result.')->group(function () {
	Route::get('op_result_terminal', function () {
		return view('op_result')->withOprand('terminal');
	})->middleware(['auth'])->name('terminal');

	Route::get('op_result_zone', function () {
		return view('op_result')->withOprand('zone');
	})->middleware(['auth'])->name('zone');

	Route::get('op_result_unit', function () {
		return view('op_result')->withOprand('unit');
	})->middleware(['auth'])->name('unit');

	Route::get('op_result_user', function () {
		return view('op_result')->withOprand('user');
	})->middleware(['auth'])->name('user');

	Route::get('op_result_customer', function () {
		return view('op_result')->withOprand('customer');
	})->middleware(['auth'])->name('customer');

	Route::get('op_result_driver', function () {
		return view('op_result')->withOprand('driver');
	})->middleware(['auth'])->name('driver');

	Route::get('op_result_driverprice', function () {
		return view('op_result')->withOprand('driverprice');
	})->middleware(['auth'])->name('driverprice');

	Route::get('op_result_chassis', function () {
		return view('op_result')->withOprand('chassis');
	})->middleware(['auth'])->name('chassis');
	
	Route::get('op_result_ssl', function () {
		return view('op_result')->withOprand('ssl');
	})->middleware(['auth'])->name('ssl');

	Route::get('op_result_company', function () {
		return view('op_result')->withOprand('company');
	})->middleware(['auth'])->name('company');

	Route::get('op_result_booking', function () {
		return view('op_result')->withOprand('booking');
	})->middleware(['auth'])->name('booking');

	Route::get('op_result_container', function () {
		return view('op_result')->withOprand('container');
	})->middleware(['auth'])->name('container');

	Route::get('op_result_dispatch', function () {
		return view('op_result')->withOprand('dispatch');
	})->middleware(['auth'])->name('dispatch');

	Route::post('/terminal_result', [TerminalController::class, 'store'])->name('terminal_add');
	Route::post('/terminal_update', [TerminalController::class, 'update'])->name('terminal_update');

	Route::post('/zone_result', [ZoneController::class, 'store'])->name('zone_add');
	Route::post('/zone_update/{id}', [ZoneController::class, 'update'])->name('zone_update');

	Route::post('/power_unit_result', [PowerUnitController::class, 'store'])->name('power_unit_add');
	Route::post('/power_unit_update', [PowerUnitController::class, 'update'])->name('power_unit_update');

	Route::post('/system_user_result', [UserController::class, 'store'])->name('system_user_add');
	Route::post('/system_user_update', [UserController::class, 'update'])->name('system_user_update');

	Route::post('/customer_result', [CustomerController::class, 'store'])->name('customer_add');
	Route::post('/customer_update', [CustomerController::class, 'update'])->name('customer_update');
	Route::post('/customer_accprice_result', [CstmAccountPriceController::class, 'store'])->name('customer_accprice_add');

	Route::post('/driver_result', [DriverController::class, 'store'])->name('driver_add');
	Route::post('/driver_update', [DriverController::class, 'update'])->name('driver_update');

	Route::post('/driver_price_result', [DriverPricesController::class, 'store'])->name('driver_price_add');
	Route::post('/driver_price_update/{id}', [DriverPricesController::class, 'update'])->name('driver_price_update');

	Route::post('/chassis_result', [ChassisController::class, 'store'])->name('chassis_add');
	Route::post('/chassis_update/{id}', [ChassisController::class, 'update'])->name('chassis_update');

	Route::post('/ssl_result', [SteamShipLineController::class, 'store'])->name('ssl_add');
	Route::post('/ssl_update/{id}', [SteamShipLineController::class, 'update'])->name('ssl_update');

	Route::post('/company_result', [CompanyController::class, 'store'])->name('company_add');
	Route::post('/company_update/{id}', [CompanyController::class, 'update'])->name('company_update');

	Route::post('/booking_result_add', [BookingController::class, 'add'])->name('booking_add');						// We use 'add' to differentiate other 'store' features as Booking and Container input are in the same form
	Route::post('/booking_update/{id}', [BookingController::class, 'update'])->name('booking_update');

	//Route::post('/container_result_add', [ContainerController::class, 'add'])->name('container_add');				// We use 'add' to differentiate other 'store' features as Booking and Container input are in the same form
	Route::post('/container_update/{id}', [ContainerController::class, 'update'])->name('container_update');

	Route::get('op_result_accprice', function () {
		return view('op_result')->withOprand('customer');
	})->middleware(['auth'])->name('accprice');

	Route::get('op_result_driver_price', function () {
		return view('op_result')->withOprand('driver_pay_prices');
	})->middleware(['auth'])->name('driver_price');
});

//////// For Misc

//////////////////////////////// For Drivers to Complete the Job ////////////////////////////////
Route::get('ContainerJob4Driver', function () {
	$driverId	= $_GET['driverId'];
	$cntnrId 	= $_GET['cntnrId'];
	return view('ContainerJob4Driver', ['driverId'=>$driverId, 'cntnrId'=>$cntnrId]);
})->middleware(['auth'])->name('ContainerJob4Driver');

//////////////////////////////// For Kernel's schedule function to receive and process the completed jobs periodically ////////////////////////////////
Route::get('ReceiveCompletedContainerJobs', function () {		// This route's function is moved to the schedule() in Kernel.php
})->middleware(['auth'])->name('ReceiveCompletedContainerJobs');

require __DIR__.'/auth.php';
