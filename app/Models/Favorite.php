<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Favorite
 * @package App\Models
 */
class Favorite extends AbstractModel
{
    /**
     * @var string[]
     */
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
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
