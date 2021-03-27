<?php


namespace App\Models;


use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Comment;

/**
 * Class AbstractModel
 * @package App\Models
 */
abstract class AbstractModel extends Model
{
    /**
     *
     */
    public const STATUSES = [
        'new' => 'Новый',
        'active' => 'Показывать',
        'nonactive' => 'Не показывать',
        'edited' => 'Отредактирован',
    ];

    /**
     * @var string[]
     */
    protected static $morphMap = [
        'comments' => Comment::class,
        'events' => Event::class,
        'places' => Place::class,
        'trips' => Trip::class
    ];

    /**
     * @param Builder $query
     * @param AbstractFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $query, AbstractFilter $filter)
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
