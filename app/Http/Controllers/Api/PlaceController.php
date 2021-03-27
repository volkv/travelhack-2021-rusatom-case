<?php

namespace App\Http\Controllers\Api;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
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
     * @param PlaceFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(PlaceFilter $filter): AnonymousResourceCollection
    {
        return PlaceResource::collection(
            Place::filter($filter)
                ->active()
                ->orderBy('priority')
                ->orderByDesc('relevance')
                ->orderByDesc('google_trends')
                ->paginate()
        );
    }
}
