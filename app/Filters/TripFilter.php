<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class TripFilter
 * @package App\Filters
 */
class TripFilter extends AbstractFilter
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
        'tourism_type_id',
        'has_places',
        'level_id',
        'age_restriction_id',
        'season_id',
    ];

    /**
     * TripFilter constructor.
     * @param Request $request
     */
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

    /**
     * @param $value
     * @return Builder
     */
    protected function categoryId($value): Builder
    {
        return $this->query->where('category_id', $value);
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
     * @return Builder
     */
    protected function hasPlaces(): Builder
    {
        return $this->query->has('places');
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function tourismTypeId($value): Builder
    {
        return $this->query->where('tourism_type_id', $value);
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
     * @param $value
     * @return Builder
     */
    protected function ageRestrictionId($value): Builder
    {
        return $this->query->where('age_restriction_id', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function seasonId($value): Builder
    {
        return $this->query->where('season_id', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function levelId($value): Builder
    {
        return $this->query->where('level_id', $value);
    }
}
