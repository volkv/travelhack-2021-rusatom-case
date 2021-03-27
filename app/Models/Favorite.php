<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class Favorite extends AbstractModel
{
    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id'
    ];

    /**
     * The model that gets favorited.
     */
    public function favoritable()
    {
        Relation::morphMap(self::$morphMap);
        return $this->morphTo();
    }

    /**
     * The user who favorited something.
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
