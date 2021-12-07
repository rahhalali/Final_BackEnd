<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
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

Route::post('/login', [UserController::class, 'login']);
Route::get('/all/events',[EventController::class,'index']);
Route::get('/get/news',[NewsController::class,'index']);
//ROOMS CRUD
Route::get('/get/rooms',[RoomController::class,'index']);
Route::get('/get/additional',[RoomController::class,'additional']);
Route::get('/get/rooms/filter-view/{id}',[RoomController::class,'filterbyview']);
Route::get('/get/rooms/filter-type/{id}',[RoomController::class,'filterbytype']);
//VIEWS CRUD
Route::get('/get/views',[ViewController::class,'index']);
//TYPE CRUD
Route::get('/get/types',[TypeController::class,'index']);
//FEATURE CRUD
Route::get('/get/features',[FeatureController::class,'index']);
//AMENITIES CRUD
Route::get('/get/amenities',[AmenityController::class,'index']);

Route::group(['middleware' => ['jwt.user']], function() {
    //LOGOUT REGISTER
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/admins', [UserController::class, 'index']);
    //ADMIN CRUD
    Route::post('/register', [UserController::class, 'register']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::put('/update/{id}',[UserController::class, 'update']);
    //NEWS CRUD
    Route::post('/add/news',[NewsController::class,'store']);
    Route::put('/update/news/{id}',[NewsController::class,'update']);
    Route::delete('/delete/news/{id}',[NewsController::class,'destroy']);
    //EVENTS CRUD
    Route::post('/events',[EventController::class,'store']);
    Route::put('/update/events/{id}',[EventController::class,'update']);
    Route::delete('/delete/events/{id}',[EventController::class,'destroy']);
    //ROOMS CRUD
    Route::put('/update/rooms/{id}',[RoomController::class,'update']);
    Route::delete('/delete/rooms/{id}',[RoomController::class,'destroy']);
    Route::post('/add/rooms',[RoomController::class,'store']);
    //VIEW CRUD
    Route::post('/add/views',[ViewController::class,'store']);
    //TYPE CRUD
    Route::post('/add/types',[TypeController::class,'store']);
    //FEATURE CRUD
    Route::post('/add/features',[FeatureController::class,'store']);
    //AMENITIES CRUD
    Route::post('/add/amenities',[AmenityController::class,'store']);
});
