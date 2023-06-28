<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::view('/', 'pages.home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'pages.login')->name('login');
    Route::view('/register', 'pages.register');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login-form', 'login');
    Route::post('/register-form', 'register');
    Route::post('/logout', 'logout');
});

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/home', 'home');

        Route::prefix('condominios')->group(function () {
            Route::get('/', 'listCondominios')->name('listCondominios');
            Route::post('/', 'listSindicos')->name('listCondominios');

            Route::post('/add', 'addCondominio');
            Route::delete('/delete/{id}', 'deleteCondominio');
            Route::get('/edit/{id}/', 'editCondominio');
            Route::get('/edit-name/{id}/', 'editNomeCondominio');

            Route::post('/add-sindico/{id}/', 'addSindico');
            Route::delete('/delete-sindico/{id}/', 'deleteSindicoAtivo');

            Route::get('/apartamento', '');
            Route::get('/edit/{idCondominio}/ap/{numAp}', 'editApartamento');
        });

        Route::prefix('sindicos')->group(function () {
            Route::get('/', 'listSindicos');

            Route::get('/edit/{idSindico}', 'editSindico');
            Route::post('/nome-sindico/{idSindico}', 'editNomeSindico');
            Route::delete('/delete/{idSindico}', 'deleteSindico');
        });
    });
});
