<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Admin\RegionController;
use App\Http\Controllers\V1\Admin\DistrictController;
use App\Http\Controllers\V1\Admin\BannerController;
use App\Http\Controllers\V1\Admin\SeasonDiscountController;
use App\Http\Controllers\V1\Admin\OrderedController;
use App\Http\Controllers\V1\Admin\DailyDiscountController;

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/banners/{banner}', [BannerController::class, 'update']);
Route::apiResource('regions', RegionController::class);
Route::apiResource('districts', DistrictController::class);
Route::apiResource('banners', BannerController::class);
Route::apiResource('orders', OrderedController::class);
Route::apiResource('season_discounts', SeasonDiscountController::class);
Route::apiResource('daily_discounts', DailyDiscountController::class);
