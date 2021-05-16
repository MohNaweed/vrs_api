<?php

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

Route::post('login','App\Http\Controllers\DriverController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('laravelapi', function (){
    return 'from laravel api';
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::name('v1.')->group(function () {
        Route::apiResources([
            'drivers' => 'App\Http\Controllers\DriverController',
            'vehicles' => 'App\Http\Controllers\VehicleController',
            'departments' => 'App\Http\Controllers\DepartmentController',
        ]);
    });
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
