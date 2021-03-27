<?php


namespace App\Models;


use App\Models\Traits\Favoritable;
use App\Models\Traits\Rateable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelista\Comments\Commentable;

class Place extends AbstractModel
{
    use Commentable;
    use Favoritable;
    use Rateable;
    use SoftDeletes;

    protected $table = 'places';

    protected $fillable = ['*'];

    protected $casts = [
        'socials'    => 'array',
        'work_hours' => 'array',
        'contacts'   => 'array'
    ];

    public function getLocationAttribute()
    {
        return [
            floatval($this->latitude),
            floatval($this->longitude)
        ];
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'place_id', 'id');
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->orderBy('sort');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'place_tag', 'place_id', 'tag_id');
    }

    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }
}
