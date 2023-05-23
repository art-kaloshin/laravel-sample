<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('section', SectionController::class);
Route::apiResource('news', NewsController::class);

Route::post('/news/search', [NewsController::class, 'index']);
