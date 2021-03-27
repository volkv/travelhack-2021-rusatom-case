<?php


namespace App\Filters;


use Illuminate\Http\Request;

class EventFilter extends AbstractFilter
{
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

    protected function startedAt($value)
    {
        return $this->query
            ->where(function ($q) use ($value) {
                $q->whereDate('stopped_at', '>=', $value)
                    ->orWhereNull('stopped_at');
            });
    }

    protected function stoppedAt($value)
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

    protected function stoppedBefore($value)
    {
        return $this->query->where('stopped_at', '<=', $value);
    }

    protected function cityId($value)
    {
        return $this->query->where('city_id', $value);
    }

    protected function categoryId($value)
    {
        return $this->query->whereIn('badge_id', explode(',', $value));
    }

    protected function favorited()
    {
        return $this->query->favorited();
    }

    protected function tourismTypeId($value)
    {
        return $this->query->where('tourism_type_id', $value);
    }

    protected function placeId($value)
    {
        return $this->query->where('place_id', $value);
    }

    protected function accessibleEnvironmentId()
    {
        return $this->query->where('accessible_environment', true);
    }

    protected function ageRestrictionId($value)
    {
        return $this->query->where('age_restriction_id', $value);
    }

    protected function seasonId($value)
    {
        return $this->query->where('season_id', $value);
    }
}
