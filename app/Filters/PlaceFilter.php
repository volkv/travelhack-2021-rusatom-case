<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PlaceFilter
 * @package App\Filters
 */
class PlaceFilter extends AbstractFilter
{
    /**
     * @var array|string[]
     */
    protected array $filtered = [
        'category_id',
        'popular',
        'city_id',
        'favorited',
        'rated',
        'open_now',
        'has_events',
    ];

    /**
     * PlaceFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $request->validate([
            'category_id' => 'integer',
            'popular' => 'nullable',
            'city_id' => 'integer',
            'favorited' => 'nullable',
            'rated' => 'nullable',
            'open_now' => 'nullable',
            'has_events' => 'nullable'
        ]);

        parent::__construct($request);
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function categoryId($value): Builder
    {
        return $this->query->where('category_id', $value);
    }

    /**
     * @return Builder
     */
    protected function popular(): Builder
    {
        return $this->query
            ->select('places.*', DB::raw('round(avg(value), 3) as ratings_average'))
            ->leftJoin('ratings', 'rateable_id', '=', DB::raw("places.id AND rateable_type = 'places'"))
            ->groupBy('places.id')
            ->orderByRaw('ratings_average DESC NULLS LAST')
            ->orderByDesc('places.id');
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function cityId($value): Builder
    {
        return $this->query->where('city_id', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function openNow($value): Builder
    {
        $dayNum = date('N');

        return $this->query->whereNotNull('work_hours->' . 'day_' . $dayNum . '_open')
            ->whereNotNull('work_hours->' . 'day_' . $dayNum . '_close')
            ->where('work_hours->' . 'day_' . $dayNum . '_open', '<', date('H:i:s'))
            ->where('work_hours->' . 'day_' . $dayNum . '_close', '>', date('H:i:s'));
    }

    /**
     * @return Builder
     */
    protected function favorited(): Builder
    {
        return $this->query->favorited();
    }

    /**
     * @return Builder
     */
    protected function rated(): Builder
    {
        return $this->query->rated();
    }

    /**
     * @return Builder
     */
    protected function hasEvents(): Builder
    {
        $now = date('Y-m-d H:i:s');

        return $this->query
            ->whereHas('events', function ($q) use ($now) {
                $q->active()
                    ->where(function ($q) use ($now) {
                        $q->whereDate('stopped_at', '>=', $now)
                            ->orWhereNull('stopped_at');
                    });
            });
    }
}