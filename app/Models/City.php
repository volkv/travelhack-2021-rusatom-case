<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * @package App\Models
 */
class City extends AbstractModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var string[]
     */
    protected $fillable = ['*'];

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
     * @return mixed
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /**
     * @return mixed
     */
    public function trips()
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
