<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SearchController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// admin route
Route::group(['as' => 'admin.', 'prefix' => 'admin/', 'middleware' => 'auth'], function(){
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // user route
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('user-store', [UserController::class, 'store'])->name('store');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('user-delete/{id}', [UserController::class, 'delete'])->name('delete');
    // profile route
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile-update', [ProfileController::class, 'update'])->name('profile.update');
    //invoice
    Route::get('invoice', function(){
       return view('layouts.backend_app');
    });
     //search
     Route::get('search', [SearchController::class, 'search']);

});

// Route::get('{path}', function () {
//     return view('admin.dashboard');
// })->where('path', '(.*)');
