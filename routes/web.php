<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('/users', 'UserController@index')->name('users.index');


// Afficher le formulaire de création d'utilisateur
Route::get('/users/create', [UserController::class, 'create']);

// Enregistrer un nouvel utilisateur
Route::post('/users', [UserController::class, 'store']);

// Afficher les détails d'un utilisateur
Route::get('/users/{id}', [UserController::class, 'show']);

// Afficher le formulaire d'édition d'utilisateur
Route::get('/users/{id}/edit', [UserController::class, 'edit']);



// Supprimer un utilisateur
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{user}', 'UserController@update')->name('users.update');
});

