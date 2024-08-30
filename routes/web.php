<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::view('add', 'add-comment');
Route::post('add', [UserController::class, 'addComment']);
Route::get('home', [UserController::class, 'allComments']);
Route::get('delete/{id}', [UserController::class, 'deleteComment']);
Route::get('update/{id}', [UserController::class, 'update']);
Route::put('update-comment/{id}', [UserController::class, 'updateComment']);
Route::get('search', [UserController::class, 'search']);
Route::get('filter', [UserController::class, 'filter']);