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
    $user =  $request->user();
    $user->department;
    return $user;
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
            'requests' => 'App\Http\Controllers\RequestController',
            'locations' => 'App\Http\Controllers\LocationController',
        ]);
        Route::post('/requests/all','App\Http\Controllers\RequestController@allRequest');
        Route::post('/requests/approved','App\Http\Controllers\RequestController@requestApproved');
    });
});



Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
