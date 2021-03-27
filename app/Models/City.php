<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * @package App\Models
 */
class City extends AbstractModel
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $guarded = [];

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
     * @return HasMany
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    /**
     * @return HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
