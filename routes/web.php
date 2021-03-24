<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\UserController;
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
Route::group(['middleware' => ['auth'], ], function () {
    Route::get('/stats', [StatsController::class, 'stats']);
    Route::get('/', [PlayersController::class,'player'])->name('home');
    Route::get('/demo', [PagesController::class,'demo']);


// Demo routes
//Route::get('/datatables', 'PagesController@datatables');
    Route::get('/players', [PlayersController::class,'player'])->name('player');
    Route::get('/csv', [PlayersController::class,'generateCsv'])->name('csv');
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users/store', [UserController::class,'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class,'edit'])->name('users.edit');
    Route::post('/users/edit/{id}', [UserController::class,'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserController::class,'destroy'])->name('users.destroy');


    Route::get('/ktdatatables', 'PagesController@ktDatatables');
    Route::get('/select2', 'PagesController@select2');
    Route::get('/jquerymask', 'PagesController@jQueryMask');
    Route::get('/icons/custom-icons', 'PagesController@customIcons');
    Route::get('/icons/flaticon', 'PagesController@flaticon');
    Route::get('/icons/fontawesome', 'PagesController@fontawesome');
    Route::get('/icons/lineawesome', 'PagesController@lineawesome');
    Route::get('/icons/socicons', 'PagesController@socicons');
    Route::get('/icons/svg', 'PagesController@svg');

// Quick search dummy route to display html elements in search dropdown (header search)
    Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
