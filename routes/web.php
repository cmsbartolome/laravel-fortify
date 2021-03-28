<?php
use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

//custom email verification for mobile dev
Route::get('/email-verification/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'verifyEmail'])->name('verify-email');
Route::get('/verification-status', function(){
    return view('status');
})->name('status');
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');
    Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update-profile');
    Route::get('/get-code', [App\Http\Controllers\UserController::class, 'generateCode'])->name('generate-code');
    Route::get('/any', function(){
        abort('404');
    });
});
//Route::get('/uploads/secure/{filename}', [App\Http\Controllers\FileController::class, 'getSecureFile'])->middleware('auth');
//Route::get('/uploads/public/{filename}', [App\Http\Controllers\FileController::class, 'getPublicFile']);

