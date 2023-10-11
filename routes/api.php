<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeCategoryController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AnnouncerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FurnitureCategoryController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SpecFurnitureCategoryController;

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
Route::name()->group(function () {

    Route::apiResource('ad', AdController::class);
    Route::apiResource('homecategories', HomeCategoryController::class);
    Route::apiResource('furniturecategories', FurnitureCategoryController::class);
    Route::apiResource('furnitures', FurnitureController::class);
    Route::apiResource('announcers', AnnouncerController::class);
    Route::apiResource('furnitures.categories', SpecFurnitureCategoryController::class)
        ->shallow()
        ->except(['update', 'show', 'destroy']);
    Route::apiResource('ad.categories', SpecFurnitureCategoryController::class)->shallow()
        ->except(['update', 'show', 'destroy']);;
});



//this route handles all request related to media file
Route::name("media.")->prefix("medias")->group(function () {

    Route::get("/{id}", [MediaController::class, "index"]);
    Route::post("/", [MediaController::class, "create"]);
    Route::delete("/{id}", [MediaController::class, "delete"]);
    Route::put("/{id}", [MediaController::class, "update"]);
    Route::post("/{announcer}", [MediaController::class, "index"]);
});



Route::post('register/', [AuthController::class, "register"]);
Route::post('login/', [AuthController::class, "login"]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
