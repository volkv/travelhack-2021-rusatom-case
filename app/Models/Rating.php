<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rating
 * @package App\Models
 */
class Rating extends AbstractModel
{
    /**
     * @var string[]
     */
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
        return $this->morphTo();
    }

    /**
     * The user who rated something.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
