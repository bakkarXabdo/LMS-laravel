<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();
if(Auth::guest())
{
    Auth::loginUsingId(1);
}
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/manage', function(){return "NOT IMPLEMENTED!";})->name('user.manage');
