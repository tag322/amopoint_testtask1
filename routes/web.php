<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AnalyticsDashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('testpage');
});

// авторизация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// дашборд и апи эндпоинт закрыты за авторизацией
Route::middleware('auth')->group(function () {
    Route::get('/analytics', [AnalyticsDashboardController::class, 'index']);
    Route::get('/analytics/visits', [AnalyticsDashboardController::class, 'visits']);
});

// трекинг без csrf, подключается на любой сайт
Route::post('/api/analytics/track', [AnalyticsController::class, 'track']);
