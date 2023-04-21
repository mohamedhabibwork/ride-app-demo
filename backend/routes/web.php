<?php

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

//require_once __DIR__.'/auth.php';

Route::get('send',function (){
   $trip = \App\Models\Trip::query()
       ->newQuery()
       ->with('user')
       ->inRandomOrder()
       ->first();

    \App\Events\Trip\TripCreatedEvent::dispatch($trip,$trip->user);
    return $trip->toArray();
});
