<?php

namespace App\Models\Traits;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Trait Rateable
 * @package App\Models\Traits
 */
trait Rateable
{
    /**
     * Fetch rating for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function rating()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    /**
     * Scope a query to records rated by the given user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRated($query)
    {
        return $query->whereHas('rating', function ($query) {
            $query->where('user_id', auth('api')->id());
        });
    }

    /**
     * Determine if the model is rated by the given user.
     *
     * @return boolean
     */
    public function isRated()
    {
        return $this->rating()
            ->where('user_id', auth('api')->id())
            ->exists();
    }

    /**
     * Have the authenticated user rated the model.
     *
     * @return void
     */
    public function setRated()
    {
        request()->validate([
            'value' => 'required|integer|min:1|max:5'
        ]);

        if ($this->isRated()) {
            $this->rating()
                ->where('user_id', auth('api')->id())
                ->update(['value' => request('value')]);
        } else {
            $this->rating()->save(
                new Rating([
                    'user_id' => auth('api')->id(),
                    'value' => request('value')
                ])
            );
        }
    }

    /**
     * Returns model user rated attribute.
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getUserRatingAttribute()
    {
        return $this->isRated()
            ?
            $this->rating()
                ->where('user_id', auth('api')->id())
                ->first()->value
            :
            null;
    }

    /**
     * @return float
     */
    public function getAverageRating()
    {
        return round($this->rating()->avg('value'), 1);
    }

    /**
     * @return int
     */
    public function getRatingCount()
    {
        return $this->rating()->count();
    }

    /**
     * Returns model average rating attribute.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        return $this->getAverageRating();
    }

    /**
     * Returns model rating count attribute.
     *
     * @return int
     */
    public function getRatingCountAttribute()
    {
        return $this->getRatingCount();
    }
}
