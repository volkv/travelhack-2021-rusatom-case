<?php


namespace App\Models;


use App\Models\Traits\Favoritable;
use App\Models\Traits\Rateable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelista\Comments\Commentable;

/**
 * Class Place
 * @package App\Models
 */
class Place extends AbstractModel
{
    use Commentable;
    use Favoritable;
    use Rateable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'places';

    /**
     * @var string[]
     */
    protected $fillable = ['*'];

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
}
