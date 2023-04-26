<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SpecialIssueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\WriterController;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middlewar->controller(OrderController::class)e group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('v1/bookdata', [BookController::class, 'data'])->name('book.external');
Route::prefix('v1/writers')->controller(WriterController::class)->group(function () {
    // Get all items
    Route::get('', 'index')->name('writers.index');
    // Get a single Writer
    Route::get('/{id}', 'show')->name('writers.show');
    // Create a new Writer
    Route::post('', 'store')->name('writers.store');
    // Update an existing Writer
    Route::put('/{writer}', 'update')->name('writers.update');
    // Delete an Writer
    Route::delete('/{writer}', 'destroy')->name('writers.destroy');
});

Route::prefix('v1/publishers')->controller(PublisherController::class)->group(function () {
    // Get all publishers
    Route::get('', 'index')->name('publishers.index');
    // Get a single publisher
    Route::get('/{id}', 'show')->name('publishers.show');
    // Create a new publisher
    Route::post('', 'store')->name('publishers.store');
    // Update an existing publisher
    Route::put('/{publisher}', 'update')->name('publishers.update');
    // Delete an publisher
    Route::delete('/{publisher}', 'destroy')->name('publishers.destroy');
});

Route::prefix('v1/translators')->controller(TranslatorController::class)->group(function () {
    // Get all translators
    Route::get('', 'index')->name('translators.index');
    // Get a single translator
    Route::get('/{id}', 'show')->name('translators.show');
    // Create a new translator
    Route::post('', 'store')->name('translators.store');
    // Update an existing translator
    Route::put('/{translator}', 'update')->name('translators.update');
    // Delete an translator
    Route::delete('/{translator}', 'destroy')->name('translators.destroy');
});

Route::prefix('v1/categories')->controller(CategoryController::class)->group(function () {
    // Get all categories
    Route::get('', 'index')->name('categories.index');
    // Get a single categorie
    Route::get('/{id}', 'show')->name('categories.show');
    // Create a new category
    Route::post('', 'store')->name('categories.store');

    // Update an existing categorie
    Route::put('/{category}', 'update')->name('categories.update');

    // Delete an categorie
    Route::delete('/{category}', 'destroy')->name('categories.destroy');
});

Route::prefix('v1/tags')->controller(TagController::class)->group(function () {
    // Get all tags
    Route::get('', 'index')->name('tags.index');

    // Get a single tag
    Route::get('/{id}', 'show')->name('tags.show');

    // Create a new tag
    Route::post('', 'store')->name('tags.store');

    // Update an existing tag
    Route::put('/{tag}', 'update')->name('tags.update');

    // Delete an tag
    Route::delete('/{tag}', 'destroy')->name('tags.destroy');
});

Route::prefix('v1/books')->controller(BookController::class)->group(function () {
    // Get all books
    Route::get('', 'index')->name('books.index');

    // Get a single book
    Route::get('/{id}', 'show')->name('books.show');

    // Create a new book
    Route::post('', 'store')->name('books.store');

    // Update an existing book
    Route::put('/{book}', 'update')->name('books.update');

    // Delete an book
    Route::delete('/{book}', 'destroy')->name('books.destroy');
});

Route::prefix('v1/magazines')->controller(MagazineController::class)->group(function () {
    // Get all magazines
    Route::get('', 'index')->name('magazines.index');

    // Get a single magazine
    Route::get('/{id}', 'show')->name('magazines.show');

    // Create a new magazine
    Route::post('', 'store')->name('magazines.store');

    // Update an existing magazine
    Route::put('/{magazine}', 'update')->name('magazines.update');

    // Delete an magazine
    Route::delete('/{magazine}', 'destroy')->name('magazines.destroy');
});

Route::prefix('v1/specialIssues')->controller(SpecialIssueController::class)->group(function () {
    // Get all specialIssues
    Route::get('', 'index')->name('specialIssues.index');

    // Get a single specialIssue
    Route::get('/{id}', 'show')->name('specialIssues.show');

    // Create a new specialIssue
    Route::post('', 'store')->name('specialIssues.store');

    // Update an existing specialIssue
    Route::put('/{specialIssue}', 'update')->name('specialIssues.update');

    // Delete an specialIssue
    Route::delete('/{specialIssue}', 'destroy')->name('specialIssues.destroy');
});
