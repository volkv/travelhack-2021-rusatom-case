<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class City extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'cities';

    protected $fillable = ['*'];

    public function getLocationAttribute()
    {
        return [
            floatval($this->latitude),
            floatval($this->longitude)
        ];
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
