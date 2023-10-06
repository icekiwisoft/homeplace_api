<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeCategoryController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AnnouncerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//this route handles all request related to home
Route::name("ad.")->group(function () {

    Route::apiResource('ad', AdController::class);
});

//this route handles all request related to  home categories
Route::name("homecategories.")->prefix("homecategories")->group(function () {

    Route::get("/", [HomeCategoryController::class, "index"]);
    Route::post("/", [HomeCategoryController::class, "index"]);
    Route::post("/{category}", [HomeCategoryController::class, "index"]);
});

//this route handles all request related to announcers
Route::name("announcer.")->prefix("announcers")->group(function () {

    Route::get("/", [AnnouncerController::class, "index"]);
    Route::post("/", [AnnouncerController::class, "index"]);
    Route::post("/{announcer}", [AnnouncerController::class, "index"]);
});

//this route handles all request related to media file
Route::name("media.")->prefix("medias")->group(function () {

    Route::get("/", [MediaController::class, "index"]);
    Route::post("/", [MediaController::class, "index"]);
    Route::post("/{announcer}", [MediaController::class, "index"]);
});



Route::post('register/', [AuthController::class, "register"]);
Route::post('login/', [AuthController::class, "login"]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
