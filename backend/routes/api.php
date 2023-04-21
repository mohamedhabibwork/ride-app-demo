<?php

use App\Http\Controllers\API\AuthenticatedController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\TripController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticatedController::class)->group(function ($router) {
    $router->post('/login', 'login')->name('login');
    $router->post('/register', 'register')->name('register');
    $router->post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
    $router->post('/login-verification', 'login_verification')->name('login-verification');
    $router->post('/exists-phone', 'existsPhone')->name('exists-phone');
});

Route::middleware('auth:sanctum')->group(function ($router){
    $router->get('/user', [AuthenticatedController::class,'currentUser'])->name('current-user')->middleware(['auth:sanctum']);

    $router->get('/driver', [DriverController::class,'driver'])->name('driver');

    Route::controller(DriverController::class)
        ->prefix('/drivers')
        ->group(function ($router) {
            $router->get('/', 'index')->name('drivers.index');
            $router->post('/', 'store')->name('drivers.store');
            $router->get('/{driver}', 'show')->name('drivers.show');
            $router->post('/{driver}/update', 'update')->name('drivers.update');
        });


    Route::controller(TripController::class)
        ->prefix('/trips')
        ->group(function ($router) {
            $router->get('/', 'index')->name('trips.index');
            $router->post('/', 'store')->name('trips.store');
            $router->get('/{trip}', 'show')->name('trips.show');
            $router->post('/{trip}/accept', 'accept')->name('trips.accept');
            $router->post('/{trip}/arrive', 'arrive')->name('trips.arrive');
            $router->post('/{trip}/start', 'start')->name('trips.start');
            $router->post('/{trip}/cancel', 'cancel')->name('trips.cancel');
            $router->post('/{trip}/complete', 'complete')->name('trips.complete');
            $router->post('/{trip}/location', 'location')->name('trips.location');
//    $router->post('/trips/{trip}/reject', 'reject')->name('trips.reject');
//    $router->post('/trips/{trip}/rate', 'rate')->name('trips.rate');
        });

});
