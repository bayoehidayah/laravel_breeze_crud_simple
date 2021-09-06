<?php

use App\Http\Controllers\BookController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('books')->as("book.")->group(function () {
        Route::get("/", [BookController::class, "index"])->name("index");
        Route::post("datas", [BookController::class, "datas"])->name("datas");
        Route::get("delete/{id}", [BookController::class, "deleteData"])->name("delete");

        Route::get("new", [BookController::class, "form"])->name("new");
        Route::get("edit/{id}", [BookController::class, "form"])->name("edit");
        Route::post("save/{id?}", [BookController::class, "saveBook"])->name("save");
    });
});

require __DIR__.'/auth.php';
