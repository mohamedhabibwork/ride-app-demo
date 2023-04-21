<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use Arr;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Driver::class, 'driver');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Driver::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $driver = $request->user()->driver()
            ->updateOrCreate([
                'user_id' => $request->user()->id,
            ], $request->validated());

        $driver->load('user');
        return $driver;
    }

    public function driver(Request $request)
    {
        return $request->user()
            ->loadMissing('driver');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        $driver->update($request->validated());
        $driver->load('user');
        return $driver;
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        $driver->load('user');
        return $driver;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        return response()->noContent();
    }
}
