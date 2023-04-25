<?php

use App\Http\Resources\BookCollection;
use App\Models\Book;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('dashboard')->group(function () {
    Route::get('', function () {
        return Inertia::render('HomeView'); })->name('dashboard');
    Route::get('/books', function () {
        return Inertia::render('BooksView', ['books' => new BookCollection(Book::all())]); })->name('books');
    Route::get('/Writers', function () {
        return Inertia::render('WritersView'); })->name('writers');
    Route::get('/Publisers', function () {
        return Inertia::render('PublishersView'); })->name('publisers');
    Route::get('/Translators', function () {
        return Inertia::render('TranslatorsView'); })->name('translators');
    Route::get('/Tags', function () {
        return Inertia::render('TagsView'); })->name('tags');
    Route::get('/Categories', function () {
        return Inertia::render('CategoriesView'); })->name('categories');
    Route::get('/magazines', function () {
        return Inertia::render('MagazinesView'); })->name('magazines');
    Route::get('/special_issue', function () {
        return Inertia::render('SpecialIssuesView'); })->name('special_issue');
    Route::get('/profile', function () {
        return Inertia::render('HomeView'); })->name('profile');
});
