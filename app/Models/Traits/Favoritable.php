<?php

namespace App\Models\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Relations\Relation;

trait Favoritable
{
    /**
     * Fetch all favorites for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        Relation::morphMap(Favorite::getMorphMap());
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Scope a query to records favorited by the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFavorited($query)
    {
        return $query->whereHas('favorites', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    /**
     * Determine if the model is favorited by the given user.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return $this->favorites()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Have the authenticated user favorite the model.
     *
     * @return void
     */
    public function toggleFavorite()
    {
        if ($this->isFavorited()) {
            $this->favorites()
                ->where('user_id', auth('api')->id())
                ->delete();
        } else {
            $this->favorites()->save(
                new Favorite(['user_id' => auth('api')->id()])
            );
        }
    }

    /**
     * Returns model favorited attribute.
     *
     * @return bool
     */
    public function getFavoritedAttribute()
    {
        return self::isFavorited();
    }
}
