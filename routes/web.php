<?php

use App\Http\Controllers\BookCopiesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalsController;
use App\Models\BookCopy;
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

//test();

Auth::routes();
Route::get('/manage', function(){return "NOT IMPLEMENTED!";})->name('user.manage');
if(Auth::guest())
{
    Auth::loginUsingId(1);
}
Route::get('/test', [BooksController::class, 'test']);
Route::resource('books', BooksController::class);
Route::post('/books/table', [BooksController::class, 'table'])->name('books.table');

Route::resource('bookcopies', BookCopiesController::class);
Route::post('/bookcopies/table', [BookCopiesController::class, 'table'])->name('bookcopies.table');
Route::get('/bookcopies/choose', [BookCopiesController::class, 'choose'])->name('bookcopies.choose');
Route::get('/bookcopies/forinventory', [BookCopiesController::class, 'forInventory'])->name('bookcopies.forinventory');
Route::get('/bookcopies/forbook', [BookCopiesController::class, 'forBook'])->name('bookcopies.forbook');

Route::resource('rentals', RentalsController::class);
Route::post('/rentals/table', [BookCopiesController::class, 'table'])->name('rentals.table');
Route::get('/rentals/forbook/{Book}', [BookCopiesController::class, 'forBook'])->name('rentals.forbook');
Route::get('/rentals/forcustomer/{Customer}', [BookCopiesController::class, 'forCustomer'])->name('rentals.forcustomer');
Route::get('/rentals/forcopy/BookCopy', [BookCopiesController::class, 'forCopy'])->name('rentals.forcopy');
Route::get('/rentals/return/{Rental}', [BookCopiesController::class, '_return'])->name('rentals.return');

Route::get('/', [HomeController::class, 'index'])->name('home');

function test(){
    BookCopy::find(27216)->rental;
    dd('END');
}