<?php

use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeCategoryController;
use App\Http\Controllers\MediaController;
use Spatie\FlareClient\Api;





//this route handles all request related to home
Route::name("ad.")->prefix("home")->group(function () {

    Route::get("/", [AdController::class, "index"]);
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
Route::get("/", [HomeController::class, "index"]);
