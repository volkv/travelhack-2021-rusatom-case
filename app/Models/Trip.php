<?php


namespace App\Models;


use App\Models\Lists\AgeRestriction;
use App\Models\Lists\Level;
use App\Models\Lists\Season;
use App\Models\Traits\Favoritable;
use App\Models\Traits\Rateable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelista\Comments\Commentable;

class Trip extends AbstractModel
{
    use SoftDeletes;
    use Commentable;
    use Favoritable;
    use Rateable;

    protected $table = 'trips';

    protected $fillable = ['*'];

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'trip_place', 'trip_id', 'place_id')->orderBy('sort');
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'trip_tag', 'trip_id', 'tag_id');
    }

    public function age_restriction(): HasOne
    {
        return $this->hasOne(AgeRestriction::class, 'id', 'age_restriction_id');
    }

    public function season(): HasOne
    {
        return $this->hasOne(Season::class, 'id', 'season_id');
    }

    public function level(): HasOne
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }
}
