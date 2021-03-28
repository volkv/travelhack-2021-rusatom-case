<?php

namespace App\Models;

use App\Interfaces\hasGoogleTrends;
use App\Models\Traits\Favoritable;
use App\Models\Traits\Rateable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravelista\Comments\Commentable;

/**
 * Class Place
 * @package App\Models
 */
class Place extends AbstractModel implements hasGoogleTrends
{
    use Commentable;
    use Favoritable;
    use Rateable;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        self::updated(function (self $model) {
            \App\Jobs\UpdateRelevance::dispatch();
        });
    }

    /**
     * @var string[]
     */
    protected $guarded = [];

    protected $fillable = ['title','priority'];


    /**
     * @var string[]
     */
    protected $casts = [
        'socials' => 'array',
        'work_hours' => 'array',
        'contacts' => 'array'
    ];

    /**
     * @return array
     */
    public function getLocationAttribute()
    {
        return [
            floatval($this->latitude),
            floatval($this->longitude)
        ];
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'place_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->orderBy('sort');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'place_tag', 'place_id', 'tag_id');
    }

    /**
     * @return HasOne
     */
    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }

    /**
     * @return string
     */
    public function getGoogleTrendsQueryAttribute(): string
    {
        return $this->title . ' ' . City::find($this->city_id)->title;
    }
}
