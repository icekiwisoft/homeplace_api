<?php


use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\HomeController;
use  App\Http\Controllers\NewsletterController;

Route::get("/", [HomeController::class, "index"]);
// Route::post('/send', 'NewsletterController@send');
Route::post('/send', [NewsletterController::class, "send"]);
