<?php

use App\Http\Controllers\BookCopiesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RentalHistoryController;
use App\Http\Controllers\RentalsController;
use App\Models\BookCopy;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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



//dev();
function test(){if (strpos(php_sapi_name(), 'cli') === false) { dev();exit;}}
function dev(){
//    $customers = \App\Models\Customer::all();
//    Db::transaction(function () use ($customers) {
//        foreach ($customers as $customer)
//        {
//            $customer->user->update(['username' => $customer->CardId]);
//        }
//    });
}
Auth::routes();
Route::get('/manage', function () {
    return "NOT IMPLEMENTED!";
})->name('user.manage');

Route::get('/books/choose', [BooksController::class, 'choose'])->name('books.choose');
Route::post('/books/table', [BooksController::class, 'table'])->name('books.table');
Route::resource('books', BooksController::class);

Route::get('/bookcopies/index?bookId={Book}&inventoryId={Inventory}', [BookCopiesController::class, 'index'])->name('bookcopies.index');
Route::post('/bookcopies/table', [BookCopiesController::class, 'table'])->name('bookcopies.table');
Route::get('/bookcopies/choose', [BookCopiesController::class, 'choose'])->name('bookcopies.choose');
Route::resource('bookcopies', BookCopiesController::class);

Route::post('/rentals/table', [RentalsController::class, 'table'])->name('rentals.table');
Route::get('/rentals/forbook/{Book}', [RentalsController::class, 'forBook'])->name('rentals.forbook');
Route::get('/rentals/forcustomer/{Customer}', [RentalsController::class, 'forCustomer'])->name('rentals.forcustomer');
Route::get('/rentals/forcopy/{BookCopy}', [RentalsController::class, 'forCopy'])->name('rentals.forcopy');
Route::post('/rentals/return/{Rental}', [RentalsController::class, 'returnRental'])->name('rentals.return');
Route::post('/rentals/ajaxreturn/{Rental}', [RentalsController::class, 'ajaxReturnRental'])->name('rentals.ajaxreturn');

Route::resource('rentals', RentalsController::class);

Route::post('/inventory/table', [InventoryController::class, 'table'])->name('inventory.table');
Route::resource('inventory', InventoryController::class);

Route::post('/customer/password/{Customer}', [CustomerController::class, 'changePassword'])->name('customer.changePassword');
Route::post('/customer/table', [CustomerController::class, 'table'])->name('customer.table');
Route::get('/customer/choose', [CustomerController::class, 'choose'])->name('customer.choose');
Route::resource('/customer', CustomerController::class);
Route::resource('/history', RentalHistoryController::class);

Route::get('/test', [PagesController::class, 'test'])->name('pages.test');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/', [PagesController::class, 'index'])->name('pages.index');
