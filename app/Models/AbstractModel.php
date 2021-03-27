<?php

namespace App\Models;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractModel
 * @package App\Models
 */
abstract class AbstractModel extends Model
{
    public const STATUSES = [
        'new' => 'Новый',
        'active' => 'Показывать',
        'nonactive' => 'Не показывать',
        'edited' => 'Отредактирован',
    ];

    /**
     * @param Builder $query
     * @param AbstractFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $query, AbstractFilter $filter): Builder
    {
        return $filter->apply($query);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
