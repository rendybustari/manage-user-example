<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\KomdaController;
use App\Http\Controllers\PengurusController;

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
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'formLogin'])->name('formLogin');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');

Route::middleware(['isSuperadmin'])->group(function () {

    Route::group(['prefix' => 'superadmin'], function() {
        Route::get('/dashboard', [SuperadminController::class,'dashboard'])->name('superadminDashboard');

        Route::get('/add', [SuperadminController::class,'formAdd'])->name('superadminFormAdd');
        Route::post('/add', [SuperadminController::class,'add'])->name('superadminAdd');

        Route::get('/edit/{user_id}', [SuperadminController::class,'formEdit'])->name('superadminFormEdit');
        Route::post('/edit/{user_id}', [SuperadminController::class,'edit'])->name('superadminEdit');

        Route::delete('/delete/{user_id}', [SuperadminController::class,'delete'])->name('superadminDelete');
    });
});

Route::middleware(['isKomda'])->group(function () {

    Route::group(['prefix' => 'komda'], function() {
        Route::get('/dashboard', [KomdaController::class,'dashboard'])->name('komdaDashboard');

        Route::get('/add', [KomdaController::class,'formAdd'])->name('komdaFormAdd');
        Route::post('/add', [KomdaController::class,'add'])->name('komdaAdd');

        Route::get('/edit/{user_id}', [KomdaController::class,'formEdit'])->name('komdaFormEdit');
        Route::post('/edit/{user_id}', [KomdaController::class,'edit'])->name('komdaEdit');

        Route::delete('/delete/{user_id}', [KomdaController::class,'delete'])->name('komdaDelete');
    });
});


Route::middleware(['isPengurus'])->group(function () {

    Route::group(['prefix' => 'pengurus'], function() {
        Route::get('/dashboard', [PengurusController::class,'dashboard'])->name('pengurusDashboard');

        Route::get('/add', [PengurusController::class,'formAdd'])->name('pengurusFormAdd');
        Route::post('/add', [PengurusController::class,'add'])->name('pengurusAdd');

        Route::get('/edit/{user_id}', [PengurusController::class,'formEdit'])->name('pengurusFormEdit');
        Route::post('/edit/{user_id}', [PengurusController::class,'edit'])->name('pengurusEdit');

        Route::delete('/delete/{user_id}', [PengurusController::class,'delete'])->name('pengurusDelete');
    });
});
