<?php

use App\Http\Controllers\BookCopiesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RentalsController;
use App\Models\BookCopy;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
function test(){if (strpos(php_sapi_name(), 'cli') === false) { dev();exit;}}
function dev(){
    $res = Db::transaction(function() {

    });
    dd($res);
}
Auth::routes();
Route::get('/manage', function () {
    return "NOT IMPLEMENTED!";
})->name('user.manage');

Route::get('/books/choose?customerId={Customer?}', [BooksController::class, 'choose'])->name('books.choose');
Route::post('/books/table', [BooksController::class, 'table'])->name('books.table');
Route::resource('books', BooksController::class);

Route::get('/bookcopies/forbook/{Book}', [BookCopiesController::class, 'forBook'])->name('bookcopies.forbook');
Route::post('/bookcopies/forbooktable', [BookCopiesController::class, 'forBookTable'])->name('bookcopies.forbooktable');

Route::get('/bookcopies/choose', [BookCopiesController::class, 'choose'])->name('bookcopies.choose');
Route::get('/bookcopies/forinventory/{Inventory}', [BookCopiesController::class, 'forInventory'])->name('bookcopies.forinventory');
Route::resource('bookcopies', BookCopiesController::class);

Route::post('/rentals/table', [RentalsController::class, 'table'])->name('rentals.table');
Route::get('/rentals/forbook/{Book}', [RentalsController::class, 'forBook'])->name('rentals.forbook');
Route::get('/rentals/forcustomer/{Customer}', [RentalsController::class, 'forCustomer'])->name('rentals.forcustomer');
Route::get('/rentals/forcopy/{BookCopy}', [RentalsController::class, 'forCopy'])->name('rentals.forcopy');
Route::get('/rentals/return/{Rental}', [RentalsController::class, 'returnRental'])->name('rentals.return');
Route::get('/rentals/create', [RentalsController::class, 'create'])->name('rentals.create');
Route::resource('rentals', RentalsController::class);

Route::post('/inventory/table', [InventoryController::class, 'table'])->name('inventory.table');
Route::resource('inventory', InventoryController::class);

Route::get('/customer/choose?copyId={BookCopy?}', [CustomerController::class, 'choose'])->name('customer.choose');
Route::resource('/customer', CustomerController::class);

Route::get('/test', function(){return view('tests.test');});
Route::get('/', [PagesController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PagesController::class, 'about']);
Route::get('/search', [PagesController::class, 'search']);
Route::get('/filter_category/{id}', [PagesController::class, 'filterCategory']);
Route::get('/filter/{id}', [PagesController::class, 'filter']);
Route::get('/about', [App\Http\Controllers\PagesController::class, 'about'])->name('pages.about');
Route::get('/search', [App\Http\Controllers\PagesController::class, 'search']);
Route::get('/filter_category/{id}', [App\Http\Controllers\PagesController::class, 'filterCategory']);
Route::get('/filter/{id}', [App\Http\Controllers\PagesController::class, 'filter']);
