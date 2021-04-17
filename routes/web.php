<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookCopiesController;
use App\Http\Controllers\BookLanguageController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\SettingsController;
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



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group([
    'middleware' => \App\Http\Middleware\IsAdmin::class
], function(){
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/books/choose', [BooksController::class, 'choose'])->name('books.choose');
    Route::get('/books/importing', [BooksController::class, 'importing'])->name('books.importing');
    Route::get('/books/export', [BooksController::class, 'export'])->name('books.export');
    Route::get('/bookcopies/export', [BookCopiesController::class, 'export'])->name('bookcopies.export');
    Route::get('/bookcopies/forBook/{book}', [BookCopiesController::class, 'forBook'])->name('bookcopies.forBook');
    Route::get('/bookcopies/choose', [BookCopiesController::class, 'choose'])->name('bookcopies.choose');
    Route::get('/bookcopies/typeahead', [BookCopiesController::class, 'typeahead'])->name('bookcopies.typeahead');
    Route::get('/rentals/forbook/{book}', [RentalsController::class, 'forBook'])->name('rentals.forbook');
    Route::get('/rentals/forstudent/{student}', [RentalsController::class, 'forStudent'])->name('rentals.forstudent');
    Route::get('/rentals/forcopy/{bookcopy}', [RentalsController::class, 'forCopy'])->name('rentals.forcopy');
    Route::get('/students/choose', [StudentsController::class, 'choose'])->name('students.choose');
    Route::get('/students/typeahead', [StudentsController::class, 'typeahead'])->name('students.typeahead');
    Route::get('/students/spciality-type-ahead', [StudentsController::class, 'specialityTypeAhead'])->name('students.specialityTypeAhead');
    Route::get('/history/export', [RentalHistoryController::class, 'export'])->name('history.export');

    Route::post('/books/table', [BooksController::class, 'table'])->name('books.table');
    Route::post('/books/import', [BooksController::class, 'import'])->name('books.import');
    Route::post('/bookcopies/table', [BookCopiesController::class, 'table'])->name('bookcopies.table');
    Route::post('/rentals/table', [RentalsController::class, 'table'])->name('rentals.table');
    Route::post('/rentals/return/{rental}', [RentalsController::class, 'returnRental'])->name('rentals.return');
    Route::post('/students/password/{student}', [StudentsController::class, 'changePassword'])->name('students.changePassword');
    Route::post('/students/table', [StudentsController::class, 'table'])->name('students.table');
    Route::post('/history/exporting', [RentalHistoryController::class, 'exporting'])->name('history.exporting');


    Route::resource('books', BooksController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('bookcopies', BookCopiesController::class);
    Route::resource('rentals', RentalsController::class);
    Route::resource('students', StudentsController::class);
    Route::resource('history', RentalHistoryController::class);
    Route::resource('categories', BookCategoryController::class, ["except" => ['show']]);
    Route::resource('languages', BookLanguageController::class, ["except" => ['show']]);
});


Route::get('/', [PagesController::class, 'index'])->name('pages.index');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');

