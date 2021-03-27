<?php


namespace App\Filters;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripFilter extends AbstractFilter
{
    protected array $filtered = [
        'category_id',
        'popular',
        'city_id',
        'favorited',
        'rated',
        'tourism_type_id',
        'has_places',
        'level_id',
        'age_restriction_id',
        'season_id',
    ];

    public function __construct(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'popular' => 'nullable',
            'city_id' => 'nullable|integer',
            'favorited' => 'nullable',
            'rated' => 'nullable',
            'level_id' => 'integer',
            'has_places' => 'nullable',
            'tourism_type_id' => 'integer',
            'age_restriction_id' => 'integer',
            'season_id' => 'integer'
        ]);

        parent::__construct($request);
    }

    protected function categoryId($value)
    {
        return $this->query->where('category_id', $value);
    }

    protected function cityId($value)
    {
        return $this->query->where('city_id', $value);
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

    protected function hasPlaces()
    {
        return $this->query->has('places');
    }

    protected function tourismTypeId($value)
    {
        return $this->query->where('tourism_type_id', $value);
    }

    protected function favorited()
    {
        return $this->query->favorited();
    }

    protected function rated()
    {
        return $this->query->rated();
    }

    protected function ageRestrictionId($value)
    {
        return $this->query->where('age_restriction_id', $value);
    }

    protected function seasonId($value)
    {
        return $this->query->where('season_id', $value);
    }

    protected function levelId($value)
    {
        return $this->query->where('level_id', $value);
    }
}
