<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdMediaController;
use App\Http\Controllers\AnnouncerAdController;
use App\Http\Controllers\AnnouncerController;
use App\Http\Controllers\AnnouncerMediaController;
use App\Http\Controllers\AnnouncerRequestsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MediaAdController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UsersController;

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\passwordResetRequestController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\WebhooksController;

// Define API resource routes
Route::apiResources([
    'announces' => AdController::class,
    'categories' => CategoryController::class,
    'announcers' => AnnouncerController::class,
    'medias' => MediaController::class,
    'users' => UsersController::class,
    'announcer-requests' => AnnouncerRequestsController::class,

]);


Route::patch('users/{user}/become-announcer', [UsersController::class, 'becomeAnnouncer']);

// Define nested API resource routes
Route::apiResource('announcers.announces', AnnouncerAdController::class)->only('index');
Route::apiResource('subscriptions', SubscriptionsController::class)->except('edit');
Route::apiResource('medias.announces', MediaAdController::class)->only('index');
Route::apiResource('announcers.medias', AnnouncerMediaController::class)->only('index');
Route::apiResource('announces.medias', AdMediaController::class)->only(['store', 'destroy', 'index']);

//some global information  route
Route::any('/', StatController::class);


// Favorite management
Route::patch('announces/{ad}/like', [FavoriteController::class, 'addToFavorites']);
Route::patch('announces/{ad}/unlike', [FavoriteController::class, 'removeFromFavorites']);


Route::apiResource('newsletters', NewsletterController::class);
Route::get('newsletter/{token}', [NewsletterController::class, 'verify']);


Route::prefix('webhooks')->group(function () {
    Route::get('campay', [WebhooksController::class, 'campay']);
});


// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'userProfile']);
    });

    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('verifyPhone/{user_id}', [AuthController::class, 'verifyPhone']);
    Route::post('resendVerificationCode/{user_id}', [AuthController::class, 'resendVerificationCode']);

    Route::post('sendEmail/', [passwordResetRequestController::class, 'sendResetLinkEmail']);
    Route::post('resetPassword/', [passwordResetRequestController::class, 'resetPassword']);

    Route::post('changePassword/', [passwordResetRequestController::class, 'changePassword']);
});
