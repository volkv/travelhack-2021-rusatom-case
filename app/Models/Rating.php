<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class Rating extends AbstractModel
{
    protected $fillable = [
        'user_id',
        'rateable_id',
        'rateable_type',
        'value'
    ];

    /**
     * The model that gets rated.
     */
    public function rateable()
    {
        Relation::morphMap(self::$morphMap);
        return $this->morphTo();
    }

    /**
     * The user who rated something.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return array $morphMap
     */
    public static function getMorphMap(): array
    {
        return self::$morphMap;
    }
}
