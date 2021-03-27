<?php


namespace App\Models;


use App\Models\Lists\AgeRestriction;
use App\Models\Lists\Season;
use App\Models\Traits\Favoritable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelista\Comments\Commentable;

class Event extends AbstractModel
{
    use Favoritable;
    use SoftDeletes;
    use Commentable;

    protected $table = 'events';

    protected $fillable = ['*'];

    public function tourism_type(): HasOne
    {
        return $this->hasOne(TourismType::class, 'id', 'tourism_type_id');
    }

    public function age_restriction(): HasOne
    {
        return $this->hasOne(AgeRestriction::class, 'id', 'age_restriction_id');
    }

    public function season(): HasOne
    {
        return $this->hasOne(Season::class, 'id', 'season_id');
    }
}
