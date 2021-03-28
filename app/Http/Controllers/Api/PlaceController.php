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
            Place::filter($filter)
                ->active()
                ->orderBy('priority')
                ->orderByDesc('relevance')
                ->orderByDesc('google_trends')
                ->paginate()
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

    public function update(Request $request) {
        $request->validate([
                'priority' => 'required',
                'title' => 'required',
                'id' => 'required',
            ]);
        $model = Place::find($request->id);
        $model->fill($request->only([
            'title',
            'priority',
        ]));

        if ($model->priority) {
            $model->relevance = $model->priority;
        }

        $model->save();
        return response()->json(['status' => 'success', 'model' => $model]);
    }
}
