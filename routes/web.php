<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PowerUnitController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\TerminalController;
use App\Models\User;
use App\Models\UserSysDetail;
use App\Models\PowerUnit;
use App\Models\Zone;
use App\Models\Terminal;

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

//////// For System Users
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
		return redirect()->route('op_result.user')->with('status', 'The user, <span style="font-weight:bold;font-style:italic;color:blue">'.$userName.'</span>, hs been deleted successfully.');	
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

//////// For Power Units
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
		return redirect()->route('op_result.unit')->with('status', 'The unit, <span style="font-weight:bold;font-style:italic;color:blue">'.$unitPlateNum.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('power_unit_delete');

//////// For Zones
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
		return redirect()->route('op_result.zone')->with('status', 'The zone, <span style="font-weight:bold;font-style:italic;color:blue">'.$zoneName.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('zone_delete');

//////// For Terminals
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
		return redirect()->route('op_result.terminal')->with('status', 'The trmnl, <span style="font-weight:bold;font-style:italic;color:blue">'.$trmnlName.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('terminal_delete');


//////// For All Results
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

	Route::post('/terminal_result', [TerminalController::class, 'store'])->name('terminal_add');
	Route::post('/terminal_update', [TerminalController::class, 'update'])->name('terminal_update');

	Route::post('/zone_result', [ZoneController::class, 'store'])->name('zone_add');
	Route::post('/zone_update/{id}', [ZoneController::class, 'update'])->name('zone_update');

	Route::post('/power_unit_result', [PowerUnitController::class, 'store'])->name('power_unit_add');
	Route::post('/power_unit_update', [PowerUnitController::class, 'update'])->name('power_unit_update');

	Route::post('/system_user_result', [UserController::class, 'store'])->name('system_user_add');
	Route::post('/system_user_update', [UserController::class, 'update'])->name('system_user_update');
});

require __DIR__.'/auth.php';
