<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AbstractFilter
 * @package App\Filters
 */
class AbstractFilter
{
    /**
     * @var array
     */
    protected array $filtered = [];

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Builder
     */
    protected Builder $query;

    /**
     * AbstractFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query)
    {
        $this->query = $query;

        $methods = $this->request->only($this->filtered);

        foreach ($methods as $method => $value) {
            $method = Str::camel($method);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this->query;
    }
}
