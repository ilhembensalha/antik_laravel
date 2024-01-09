<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AnnonceController;
use App\Http\Controllers\API\CategorieController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function () {
});


Route::put('/editProfile/{user_id}', [AuthController::class, 'editProfile'])->name('users.editProfile');
Route::POST('/updateProfileImage/{user_id}', [App\Http\Controllers\API\AuthController::class, 'updateProfileImage']);
Route::get('/getUserImage/{user_id}', [AuthController::class, 'getUserImage']);

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
Route::get('/profile/{user_id}', [AuthController::class, 'profile']);

Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');
Route::get('/annoncesImage/{annonce}', [AnnonceController::class, 'showImage']);

Route::Post('annoncesupdate/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');

Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');
//Route::resource('/categories', 'API\CategorieController');

Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategorieController::class, 'store'])->name('categories.store');

Route::get('/categories/{categorie}', [App\Http\Controllers\API\CategorieController::class, 'show']);

Route::match(['put', 'patch'], 'categories/{categorie}', [CategorieController::class, 'update'])->name('categories.update');
Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');


Route::get('/messages/{userId}', [MessageController::class, 'getMessages']);
Route::post('/messages/send', [MessageController::class, 'sendMessage']);


// Ajouter à la liste des favoris
Route::post('/favorites/add', [FavoriteController::class, 'addToFavorites']);

// Retirer des favoris
Route::post('/favorites/remove', [FavoriteController::class, 'removeFromFavorites']);

// Récupérer les favoris d'un utilisateur
Route::get('/favorites', [FavoriteController::class, 'getFavorites']);