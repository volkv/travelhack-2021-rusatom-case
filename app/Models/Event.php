<?php

namespace App\Models;

use App\Interfaces\hasGoogleTrends;
use App\Models\Lists\AgeRestriction;
use App\Models\Lists\Season;
use App\Models\Traits\Favoritable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelista\Comments\Commentable;

/**
 * Class Event
 * @package App\Models
 */
class Event extends AbstractModel implements hasGoogleTrends
{
    use Favoritable;
    use SoftDeletes;
    use Commentable;

    /**
     * @var string[]
     */
    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }

    /**
     * @return HasOne
     */
    public function age_restriction(): HasOne
    {
        return $this->hasOne(AgeRestriction::class, 'id', 'age_restriction_id');
    }

    /**
     * @return HasOne
     */
    public function season(): HasOne
    {
        return $this->hasOne(Season::class, 'id', 'season_id');
    }

    /**
     * @return string
     */
    public function getGoogleTrendsQueryAttribute(): string
    {
        return $this->title . ' ' . City::find($this->city_id)->title;
    }
}
