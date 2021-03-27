<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class EventFilter
 * @package App\Filters
 */
class EventFilter extends AbstractFilter
{
    /**
     * @var array|string[]
     */
    protected array $filtered = [
        'started_at',
        'stopped_at',
        'stopped_before',
        'city_id',
        'category_id',
        'favorited',
        'tourism_type_id',
        'place_id',
        'accessible_environment',
        'age_restriction_id',
        'season_id',
    ];

    /**
     * EventFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $request->validate([
            'started_at' => 'nullable|date|date_format:Y-m-d',
            'stopped_at' => 'nullable|date|date_format:Y-m-d',
            'stopped_before' => 'nullable|date|date_format:Y-m-d',
            'city_id' => 'integer',
            'category_id' => 'regex:/^[^!,][\d\s,]*$/',
            'favorited' => 'nullable',
            'tourism_type_id' => 'integer',
            'place_id' => 'integer',
            'accessible_environment' => 'nullable',
            'age_restriction_id' => 'integer',
            'season_id' => 'integer',
        ]);

        parent::__construct($request);
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function startedAt($value): Builder
    {
        return $this->query
            ->where(function ($q) use ($value) {
                $q->whereDate('stopped_at', '>=', $value)
                    ->orWhereNull('stopped_at');
            });
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function stoppedAt($value): Builder
    {
        return $this->query
            ->where(function ($q) use ($value) {
                $q->whereDate('started_at', '<=', $value)
                    ->orWhere(function ($q) use ($value) {
                        $q->orWhereNull('started_at')
                            ->whereDate('created_at', '<=', $value);
                    });
            });
    }

    /**
     * @param $value
     * @return Builder
     */
    protected function stoppedBefore($value): Builder
    {
        return $this->query->where('stopped_at', '<=', $value);
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
    protected function categoryId($value): Builder
    {
        return $this->query->whereIn('badge_id', explode(',', $value));
    }

    /**
     * @return Builder
     */
    protected function favorited(): Builder
    {
        return $this->query->favorited();
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
     * @param $value
     * @return Builder
     */
    protected function placeId($value): Builder
    {
        return $this->query->where('place_id', $value);
    }

    /**
     * @return Builder
     */
    protected function accessibleEnvironmentId(): Builder
    {
        return $this->query->where('accessible_environment', true);
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
}
