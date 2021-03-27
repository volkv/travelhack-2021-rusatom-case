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

/**
 * Class Trip
 * @package App\Models
 */
class Trip extends AbstractModel
{
    use SoftDeletes;
    use Commentable;
    use Favoritable;
    use Rateable;

    /**
     * @var string
     */
    protected $table = 'trips';

    /**
     * @var string[]
     */
    protected $fillable = ['*'];

    /**
     * @return BelongsToMany
     */
    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'trip_place', 'trip_id', 'place_id')->orderBy('sort');
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'trip_tag', 'trip_id', 'tag_id');
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
     * @return HasOne
     */
    public function level(): HasOne
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    /**
     * @return HasOne
     */
    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }
}
