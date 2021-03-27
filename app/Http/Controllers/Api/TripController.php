<?php


namespace App\Http\Controllers\Api;


use App\Filters\TripFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TripFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(TripFilter $filter)
    {
        return TripResource::collection(
            Trip::filter($filter)->active()->paginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Trip $trip
     * @return TripResource
     */
    public function show(Trip $trip): TripResource
    {
        return new TripResource($trip->load('places'));
    }
}
