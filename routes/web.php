<?php

use App\Http\Controllers\BookCopiesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RentalHistoryController;
use App\Http\Controllers\RentalsController;
use App\Models\Book;
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
Route::get('/books/importing', [BooksController::class, 'importing'])->name('books.importing');
Route::post('/import', [BooksController::class, 'import'])->name('books.import');
Route::get('/books/export', [BooksController::class, 'export'])->name('books.export');
Route::resource('books', BooksController::class);

Route::get('/bookcopies/index?bookId={book}&inventoryId={inventory}', [BookCopiesController::class, 'index'])->name('bookcopies.index');
Route::post('/bookcopies/table', [BookCopiesController::class, 'table'])->name('bookcopies.table');
Route::get('/bookcopies/choose', [BookCopiesController::class, 'choose'])->name('bookcopies.choose');
Route::resource('bookcopies', BookCopiesController::class);
Route::get('/bookcopies/typeahead', [BookCopiesController::class, 'typeahead'])->name('bookcopies.typeahead');

Route::post('/rentals/table', [RentalsController::class, 'table'])->name('rentals.table');
Route::get('/rentals/forbook/{book}', [RentalsController::class, 'forBook'])->name('rentals.forbook');
Route::get('/rentals/forcustomer/{customer}', [RentalsController::class, 'forCustomer'])->name('rentals.forcustomer');
Route::get('/rentals/forcopy/{bookcopy}', [RentalsController::class, 'forCopy'])->name('rentals.forcopy');
Route::post('/rentals/return/{rental}', [RentalsController::class, 'returnRental'])->name('rentals.return');
Route::post('/rentals/ajaxreturn/{rental}', [RentalsController::class, 'ajaxReturnRental'])->name('rentals.ajaxreturn');

Route::resource('rentals', RentalsController::class);

Route::post('/inventory/table', [InventoryController::class, 'table'])->name('inventory.table');
Route::resource('inventory', InventoryController::class);

Route::post('/students/password/{Student}', [StudentsController::class, 'changePassword'])->name('students.changePassword');
Route::post('/students/table', [StudentsController::class, 'table'])->name('students.table');
Route::get('/students/choose', [StudentsController::class, 'choose'])->name('students.choose');
Route::get('/students/typeahead', [StudentsController::class, 'typeahead'])->name('students.typeahead');
Route::resource('/students', StudentsController::class);

Route::resource('/history', RentalHistoryController::class);

Route::get('/test', [PagesController::class, 'test'])->name('pages.test');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/', [PagesController::class, 'index'])->name('pages.index');
