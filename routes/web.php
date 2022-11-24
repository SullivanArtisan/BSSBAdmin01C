<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\UserSysDetail;

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
 
//$url = route('profile', ['id' => 1]);
require __DIR__.'/auth.php';
