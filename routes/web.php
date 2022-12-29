<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PowerUnitController;
use App\Http\Controllers\ZoneController;
use App\Models\User;
use App\Models\UserSysDetail;
use App\Models\PowerUnit;
use App\Models\Zone;

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

Route::get('/system_user_main', function () {
    return view('system_user_main');
})->middleware(['auth'])->name('system_user_main');

Route::get('system_user_selected', function (Request $request) {
    return view('system_user_selected');
})->middleware(['auth'])->name('system_user_selected');

Route::get('system_user_name_selected', function (Request $request) {
    return view('system_user_name_selected');
})->middleware(['auth'])->name('system_user_name_selected');

Route::get('system_user_email_selected', function (Request $request) {
    return view('system_user_email_selected');
})->middleware(['auth'])->name('system_user_email_selected');

Route::get('/system_user_add', function () {
    return view('system_user_add');
})->middleware(['auth'])->name('system_user_add');

Route::get('/system_user_delete', function () {
	$id = $_GET['id'];
	$user = User::where('id', $id)->first();
	$userName = $user->name;
	$res=UserSysDetail::where('user_id', $id)->delete();
	if (!$res) {
		return redirect('system_user_result')->with('status', 'The user, <span style="font-weight:bold;font-style:italic;color:red">'.$userName.'</span>, cannot be deleted for some reason.');	
	} else {
		User::where('id', $id)->delete();
		return redirect('system_user_result')->with('status', 'The user, <span style="font-weight:bold;font-style:italic;color:blue">'.$userName.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('system_user_delete');

Route::get('/system_user_result', function () {
    return view('system_user_result');
})->middleware(['auth'])->name('system_user_result');

Route::post('/system_user_result', [UserController::class, 'store']);

Route::post('/system_user_update', [UserController::class, 'update']);

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

Route::get('/power_unit_main', function () {
    return view('power_unit_main');
})->middleware(['auth'])->name('power_unit_main');

Route::get('power_unit_selected', function (Request $request) {
    return view('power_unit_selected');
})->middleware(['auth'])->name('power_unit_selected');

Route::get('/power_unit_result', function () {
    return view('power_unit_result');
})->middleware(['auth'])->name('power_unit_result');

Route::get('power_unit_id_selected', function (Request $request) {
    return view('power_unit_id_selected');
})->middleware(['auth'])->name('power_unit_id_selected');

Route::get('power_unit_plate_number_selected', function (Request $request) {
    return view('power_unit_plate_number_selected');
})->middleware(['auth'])->name('power_unit_plate_number_selected');

Route::get('/power_unit_add', function () {
    return view('power_unit_add');
})->middleware(['auth'])->name('power_unit_add');

Route::get('/power_unit_delete', function () {
	$id = $_GET['id'];
	$unit = PowerUnit::where('id', $id)->first();
	$unitPlateNum = $unit->plate_number;
	$res=PowerUnit::where('id', $id)->delete();
	if (!$res) {
		return redirect('power_unit_result')->with('status', 'The unit, <span style="font-weight:bold;font-style:italic;color:red">'.$unitPlateNum.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect('power_unit_result')->with('status', 'The unit, <span style="font-weight:bold;font-style:italic;color:blue">'.$unitPlateNum.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('power_unit_delete');

Route::post('/power_unit_result', [PowerUnitController::class, 'store']);

Route::post('/power_unit_update', [PowerUnitController::class, 'update']);

Route::get('/zone_main', function () {
    return view('zone_main');
})->middleware(['auth'])->name('zone_main');

Route::get('/zone_add', function () {
    return view('zone_add');
})->middleware(['auth'])->name('zone_add');

Route::get('zone_selected', function (Request $request) {
    return view('zone_selected');
})->middleware(['auth'])->name('zone_selected');

Route::get('zone_name_selected', function (Request $request) {
    return view('zone_name_selected');
})->middleware(['auth'])->name('zone_name_selected');

Route::get('zone_group_selected', function (Request $request) {
    return view('zone_group_selected');
})->middleware(['auth'])->name('zone_group_selected');

Route::get('zone_fsc_deduction_selected', function (Request $request) {
    return view('zone_fsc_deduction_selected');
})->middleware(['auth'])->name('zone_fsc_deduction_selected');

Route::get('/zone_delete/{id}', function ($id) {
	$zone = Zone::where('id', $id)->first();
	$zoneName = $zone->zone_name;
	$res=Zone::where('id', $id)->delete();
	if (!$res) {
		return redirect('zone_result')->with('status', 'The zone, <span style="font-weight:bold;font-style:italic;color:red">'.$zoneName.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect('zone_result')->with('status', 'The zone, <span style="font-weight:bold;font-style:italic;color:blue">'.$zoneName.'</span>, hs been deleted successfully.');	
	}
})->middleware(['auth'])->name('zone_delete');

Route::post('/zone_update/{id}', [ZoneController::class, 'update'])->name('zone_update');

Route::get('/zone_result', function () {
    return view('zone_result');
})->middleware(['auth'])->name('zone_result');

Route::post('/zone_result', [ZoneController::class, 'store']);

//$url = route('profile', ['id' => 1]);
require __DIR__.'/auth.php';
