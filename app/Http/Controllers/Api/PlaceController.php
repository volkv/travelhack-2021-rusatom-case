<?php

namespace App\Http\Controllers\Api;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class PlaceController
 * @package App\Http\Controllers\Api
 */
class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  PlaceFilter  $filter
     * @return AnonymousResourceCollection
     */
    public function index(PlaceFilter $filter): AnonymousResourceCollection
    {
        return PlaceResource::collection(
            Place::filter($filter)->active()->paginate()
        );
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'latitude' => 'nullable|float',
                'longitude' => 'nullable|float',
            ]
        );


      $created =   Place::create($request->only('title', 'description', 'latitude', 'longitude'));

      return response()->json($created->toArray());
    }
}
