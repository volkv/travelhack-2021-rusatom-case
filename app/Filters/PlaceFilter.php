<?php


namespace App\Filters;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceFilter extends AbstractFilter
{
    protected array $filtered = [
        'category_id',
        'popular',
        'city_id',
        'favorited',
        'rated',
        'open_now',
        'has_events',
    ];

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

    protected function categoryId($value)
    {
        return $this->query->where('category_id', $value);
    }

    protected function popular()
    {
        return $this->query
            ->select('places.*', DB::raw('round(avg(value), 3) as ratings_average'))
            ->leftJoin('ratings', 'rateable_id', '=', DB::raw("places.id AND rateable_type = 'places'"))
            ->groupBy('places.id')
            ->orderByRaw('ratings_average DESC NULLS LAST')
            ->orderByDesc('places.id');
    }

    protected function cityId($value)
    {
        return $this->query->where('city_id', $value);
    }

    protected function openNow($value)
    {
        $dayNum = date('N');

        return $this->query->whereNotNull('work_hours->' . 'day_' . $dayNum . '_open')
            ->whereNotNull('work_hours->' . 'day_' . $dayNum . '_close')
            ->where('work_hours->' . 'day_' . $dayNum . '_open', '<', date('H:i:s'))
            ->where('work_hours->' . 'day_' . $dayNum . '_close', '>', date('H:i:s'));
    }

    protected function favorited()
    {
        return $this->query->favorited();
    }

    protected function rated()
    {
        return $this->query->rated();
    }

    protected function hasEvents()
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
