<?php


namespace App\Http\Controllers\Api;


use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PlaceFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(PlaceFilter $filter)
    {
        return PlaceResource::collection(
            Place::filter($filter)->active()->paginate()
        );
    }
}
