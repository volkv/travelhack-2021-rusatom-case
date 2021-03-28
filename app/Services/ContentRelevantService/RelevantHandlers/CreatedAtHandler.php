<?php


namespace App\Services\ContentRelevantService\RelevantHandlers;


use Carbon\Carbon;

/**
 * Class CreatedAtHandler
 * @package App\Services\ContentRelevantService\RelevantHandlers
 */
class CreatedAtHandler extends AbstractRelevantHandler implements Handler
{
    /**
     * @var
     */
    private $created_at;

    /**
     * CreatedAtHandler constructor.
     * @param $created_at
     */
    public function __construct($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param int $sum
     * @param $model_class
     * @return int|null
     */
    public function handle(int $sum, $model_class): ?int
    {
        if ($this->created_at) {
            $diff_in_days = $this->created_at->diffInDays(Carbon::now());
            if ($diff_in_days < 7) {
                $sum *= 1.75;
            }
            if ($diff_in_days < 30) {
                $sum *= 1.5;
            }
            if ($diff_in_days < 180) {
                $sum *= 1.25;
            }
        }
        return parent::handle($sum, $model_class);
    }
}
