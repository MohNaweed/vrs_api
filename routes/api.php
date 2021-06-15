<?php

use App\Models\Driver;
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


    $driver = Driver::where('user_id', '=', $user->id)->first();
    if ($driver !== null) {
        $user->is_driver = true;
    }
    else{
        $user->is_driver = false;
    }
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
            'requestfuel' => 'App\Http\Controllers\RequestFuelController'
        ]);
        Route::post('/requests/all','App\Http\Controllers\RequestController@allRequest');
        Route::post('/requests/fuel/all','App\Http\Controllers\RequestFuelController@allRequest');
        Route::post('/requests/approved','App\Http\Controllers\RequestController@requestApproved');
        Route::post('/requests/fuel/approved','App\Http\Controllers\RequestFuelController@requestApproved');
        Route::post('/test','App\Http\Controllers\RequestController@test');
    });
});



Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
