<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdMediaController;
use App\Http\Controllers\AnnouncerAdController;
use App\Http\Controllers\AnnouncerController;
use App\Http\Controllers\AnnouncerMediaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\MediaAdController;
use App\Http\Controllers\MediaController;

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\StatController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//this route handles all request related to home
Route::name()->group(function () {

    Route::apiResources([
      'ads'=>AdController::class,
        'categories'=> CategoryController::class ,
        'announcers'=> AnnouncerController::class,
        'medias'=> MediaController::class
    ]);

    Route::apiResource('announcers.ads', AnnouncerAdController::class)->only([
        "index",
    ]);;

    Route::apiResource('medias', MediaController::class);

    Route::apiResource('medias.ads', MediaAdController::class)->only([
        "index"
    ]);

    Route::apiResource('announcers.medias', AnnouncerMediaController::class)->only([
        "index",
    ]);;


    Route::any("/", StatController::class);
    Route::apiResource('ads.medias', AdMediaController::class)->only([
        "store", "destroy", "index"
    ]);

});




Route::name("newsletter.")->prefix("newsletter")->group(function () {
    Route::middleware("auth")->group(function () {

        Route::get("/", [NewsletterController::class, "index"]);
        Route::post("/", [NewsletterController::class, "store"]);
});
});


Route::post('register/', [AuthController::class, "register"]);
Route::post('login/', [AuthController::class, "login"]);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::get('/user-profile', [AuthController::class, 'userProfile']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

