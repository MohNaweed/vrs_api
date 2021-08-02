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
    $user->unreadNotificationsCount = $user->unreadNotifications->count();
    $user->notifications = $user->notifications;


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
            'requestfuel' => 'App\Http\Controllers\RequestFuelController',
            'gasstations' => 'App\Http\Controllers\GasStationController',
        ]);
        Route::post('/requests/all','App\Http\Controllers\RequestController@allRequest');
        Route::post('/requests/cleared','App\Http\Controllers\RequestController@clearedRequests');
        Route::post('/requests/belongs','App\Http\Controllers\RequestController@belongsRequests');
        Route::post('/requests/approved','App\Http\Controllers\RequestController@requestApproved');


        Route::post('/requests/fuel/all','App\Http\Controllers\RequestFuelController@allRequest');
        Route::post('/requests/fuel/pendings','App\Http\Controllers\RequestFuelController@pendingRequests');
        Route::post('/requests/fuel/approved','App\Http\Controllers\RequestFuelController@requestApproved');


        //Notifications API
        Route::get('/notifications/read','App\Http\Controllers\NotificationController@readNotifications');
        Route::get('/notifications/all','App\Http\Controllers\NotificationController@notifications');
        Route::get('/notifications/unread','App\Http\Controllers\NotificationController@unreadNotifications');
        Route::post('/notifications/markasread','App\Http\Controllers\NotificationController@markAsReadNotifications');
        Route::post('/notifications/destroy','App\Http\Controllers\NotificationController@destroyNotifications');

        //tests
        Route::post('/test','App\Http\Controllers\RequestController@test');
        Route::get('/vehicle/notrelated','App\Http\Controllers\DriverController@doesNotHaveVechile');
        Route::get('/gasstations/delete/{id}','App\Http\Controllers\GasStationController@delete');
    });
});



Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);
