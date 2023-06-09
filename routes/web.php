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
    return Inertia::render('IndexView');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('dashboard')->group(function () {
    Route::get('', function () {
        return Inertia::render('HomeView'); })->name('dashboard');
    Route::get('/books', function () {
        return Inertia::render('BooksView'); })->name('books');
    Route::get('/writers', function () {
        return Inertia::render('WritersView'); })->name('writers');
    Route::get('/publisers', function () {
        return Inertia::render('PublishersView'); })->name('publisers');
    Route::get('/translators', function () {
        return Inertia::render('TranslatorsView'); })->name('translators');
    Route::get('/tags', function () {
        return Inertia::render('TagsView'); })->name('tags');
    Route::get('/categories', function () {
        return Inertia::render('CategoriesView'); })->name('categories');
    Route::get('/magazines', function () {
        return Inertia::render('MagazinesView'); })->name('magazines');
    Route::get('/special_issue', function () {
        return Inertia::render('SpecialIssuesView'); })->name('special_issues');
    Route::get('/profile', function () {
        return Inertia::render('ProfileView'); })->name('profile');
    Route::get('/notifications', function () {
        return Inertia::render('NotificationsView'); })->name('notifications');
});
