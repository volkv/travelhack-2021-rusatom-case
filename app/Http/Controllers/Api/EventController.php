<?php


namespace App\Http\Controllers\Api;


use App\Filters\EventFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class EventController
 * @package App\Http\Controllers\Api
 */
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EventFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(EventFilter $filter)
    {
        return EventResource::collection(
            Event::filter($filter)->active()->paginate()
        );
    }
}
