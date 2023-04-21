<?php

namespace App\Http\Controllers\API;

use App\Events\Trip\TripAcceptEvent;
use App\Events\Trip\TripCancelledByDriverEvent;
use App\Events\Trip\TripCancelledByPassengerEvent;
use App\Events\Trip\TripCreatedEvent;
use App\Events\Trip\TripDriverArrivedEvent;
use App\Events\Trip\TripEndedEvent;
use App\Events\Trip\TripLocationUpdatedEvent;
use App\Events\Trip\TripStartedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Trip;
use DB;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Str;

class TripController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Trip::class, 'trip');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Trip::where(function ($q) use ($request) {
            $q->whereBelongsTo($request->user(), 'user');
            if ($request->user()->driver()->exists()) {
                $q->orWhere('driver_id', $request->user()->driver->id);
            }
        })
            ->latest()
            ->with('driver.user', 'user')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        $data = [
            'start_code' => mt_rand(100000, 999999),
            'cost' => max(10, round($request->float('distance') * 3.5, 2)),
            'channel' => Str::uuid()->toString(),
            'origin' => $this->getPoint($request->get('origin')),
            'destination' => $this->getPoint($request->get('destination')),
            'user_location' => $this->getPoint($request->get('user_location')),
            'destination_name' => $request->get('destination_name'),
            'distance' => $request->float('distance'),
        ];
        $trip = $request->user()->trips()->create($data);
        /* @var Trip $trip */
        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripCreatedEvent::dispatch($trip, $request->user());
        return $trip;
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
//        $trip->load('driver.user', 'user');
        return response()->json($trip);
    }

    public function accept(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => ['required','array:lat,lng'],
            'driver_location.lat' => 'required|numeric',
            'driver_location.lng' => 'required|numeric',
        ]);

        $trip->update([
            'driver_id' => $request->user()->driver->id,
            'accepted_at' => now(),
            'driver_location' => $this->getPoint($request->get('driver_location')),
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripAcceptEvent::dispatch($trip, $request->user());
        return $trip;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());
        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch

        return $trip;
    }

    public function arrive(Request $request, Trip $trip)
    {
        $trip->update([
            'arrived_at' => now(),
            'is_arrived' => true,
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripDriverArrivedEvent::dispatch($trip, $request->user());
        return $trip;
    }

    public function complete(Request $request, Trip $trip)
    {
        $trip->update([
            'complete_at' => now(),
            'is_complete' => true,
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripEndedEvent::dispatch($trip, $request->user());
        return $trip;
    }

    public function cancel(Request $request, Trip $trip)
    {
        $trip->update([
            'is_cancelled' => true,
            'cancelled_at' => now(),
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        if ($trip->user->is($request->user())) {
            TripCancelledByPassengerEvent::dispatch($trip, $request->user());
        } else {
            TripCancelledByDriverEvent::dispatch($trip, $request->user());
        }
        return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
        $request->validate([
            'start_code' => ['required', 'numeric', 'digits:6', 'in:' . $trip->start_code],
        ]);

        $trip->update([
            'is_started' => true,
            'started_at' => now(),
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripStartedEvent::dispatch($trip, $request->user());
        return $trip;
    }

    public function location(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => ['required','array:lat,lng'],
            'driver_location.lat' => 'required|numeric',
            'driver_location.lng' => 'required|numeric',
        ]);

        $trip->update([
            'driver_location' => $this->getPoint($request->get('driver_location')),
        ]);

        $trip->refresh()
            ->loadMissing('driver.user', 'user');
        // Dispatch
        TripLocationUpdatedEvent::dispatch($trip, $request->user());
        return $trip;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->noContent();
    }

    /**
     * @param array{lat:float,lng:float} $point
     * @return \Illuminate\Contracts\Database\Query\Expression|Expression
     */
    private function getPoint(array $point)
    {
        return DB::raw("ST_GeomFromText('POINT({$point['lat']} {$point['lng']})')");
    }
}
