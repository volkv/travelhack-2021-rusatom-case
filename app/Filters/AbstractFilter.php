<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AbstractFilter
{
    protected array $filtered = [];

    private Request $request;

    protected Builder $query;

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
