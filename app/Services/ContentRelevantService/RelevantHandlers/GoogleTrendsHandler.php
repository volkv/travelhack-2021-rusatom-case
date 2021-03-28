<?php


namespace App\Services\ContentRelevantService\RelevantHandlers;


/**
 * Class GoogleTrendsHandler
 * @package App\Services\ContentRelevantService\RelevantHandlers
 */
class GoogleTrendsHandler extends AbstractRelevantHandler implements Handler
{
    private $current_trends;

    private int $max_trends;

    public function __construct($current_trends, $max_trends)
    {
        $this->current_trends = $current_trends;
        $this->max_trends = $max_trends;
    }

    /**
     * @param int $sum
     * @param $model_class
     * @return int|null
     */
    public function handle(int $sum, $model_class): ?int
    {
        if ($this->current_trends && $this->max_trends) {
            $divider = $this->max_trends / 100;
            $sum = ceil($this->current_trends / $divider);
        } else {
            $sum = 1;
        }
        return parent::handle($sum, $model_class);
    }

}
