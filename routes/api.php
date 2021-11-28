<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', ['App\Http\Controllers\UserController', 'login']);

Route::group(['middleware' => ['jwt.user']], function() {
    Route::post('/logout', ['App\Http\Controllers\UserController', 'logout']);
    Route::get('/admins', ['App\Http\Controllers\UserController', 'index']);
    Route::post('/register', ['App\Http\Controllers\UserController', 'register']);
    Route::delete('/delete/{id}', ['App\Http\Controllers\UserController', 'delete']);
    Route::put('/update/{id}',['App\Http\Controllers\UserController', 'update']);
});
