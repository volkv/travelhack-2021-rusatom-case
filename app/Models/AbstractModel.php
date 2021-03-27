<?php


namespace App\Models;


use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Comment;

abstract class AbstractModel extends Model
{
    public const STATUSES = [
        'new' => 'Новый',
        'active' => 'Показывать',
        'nonactive' => 'Не показывать',
        'edited' => 'Отредактирован',
    ];

    protected static $morphMap = [
        'comments' => Comment::class,
        'events' => Event::class,
        'places' => Place::class,
        'trips' => Trip::class
    ];

    public function scopeFilter(Builder $query, AbstractFilter $filter)
    {
        return $filter->apply($query);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
