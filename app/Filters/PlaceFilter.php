<?php

namespace App\Filters;

use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        'sort',
        'locationRadius',
        'search',
    ];

    /**
     * PlaceFilter constructor.
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $request->validate([
            'locationRadius' => 'nullable|int',
            'category_id' => 'integer',
            'popular' => 'nullable',
            'city_id' => 'integer',
            'favorited' => 'nullable',
            'rated' => 'nullable',
            'open_now' => 'nullable',
            'has_events' => 'nullable',
            'sort' => 'nullable|string|in:relevance,created_at,avg,distance',
        ]);

        parent::__construct($request);
    }


    static function getSQLDistance(): ?string
    {
        if (!$locationString = \request()->userLocation) {
            return null;
        }

        $coords = explode(',', $locationString);

        if (count($coords) != 2) {
            return null;
        }

        $lat = $coords[0];
        $long = $coords[1];

        return "6371 *
   acos(cos(radians($lat)) *
   cos(radians(latitude)) *
   cos(radians(longitude) - radians($long)) +
   sin(radians($lat)) *
   sin(radians(latitude )))";
    }


    /**
     * @param $value
     * @return Builder
     */
    protected function locationRadius($value): Builder
    {

        if ($sqlDistance = self::getSQLDistance()) {
            return $this->query->addSelect([
                 DB::raw("($sqlDistance) AS distance")
            ])->where(DB::raw($sqlDistance), '<', $value);
        }

        return $this->query;
    }

    protected function sort($value): Builder
    {
        if ($sqlDistance = self::getSQLDistance()) {
            $this->query->select([
                '*', DB::raw("($sqlDistance) AS distance")
            ]);

            if ($value == 'distance') {

                return $this->query->orderBy('distance');
            }
        }

        if ($value == 'avg') {
            return $this->query->select('places.*')->leftJoin('ratings', 'places.id', '=', 'ratings.rateable_id')
                ->addSelect(DB::raw('coalesce(AVG(ratings.value),0) as average_rating'))
                ->groupBy('places.id')
                ->orderByDesc('average_rating');
        }

        if ($value == 'relevance') {
            return $this->query->orderByDesc('relevance');
        }

        if ($value == 'created_at') {
            return $this->query->orderByDesc('created_at');
        }

        return $this->query;
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function search($value): Builder
    {
        if (\request()->search) {
            return $this->query->where('title', 'LIKE', '%'.$value.'%');
        }
        return $this->query;
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

        return $this->query->whereNotNull('work_hours->'.'day_'.$dayNum.'_open')
            ->whereNotNull('work_hours->'.'day_'.$dayNum.'_close')
            ->where('work_hours->'.'day_'.$dayNum.'_open', '<', date('H:i:s'))
            ->where('work_hours->'.'day_'.$dayNum.'_close', '>', date('H:i:s'));
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
