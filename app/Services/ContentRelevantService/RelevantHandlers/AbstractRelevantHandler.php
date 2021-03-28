<?php

namespace App\Services\ContentRelevantService\RelevantHandlers;

/**
 * Class AbstractRelevantHandler
 * @package App\Services\ContentRelevantService\RelevantHandlers
 */
abstract class AbstractRelevantHandler
{
    /**
     * @var
     */
    private $nextHandler;

    /**
     * @param Handler $handler
     * @return Handler
     */
    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    /**
     * @param int $sum
     * @param $model_class
     * @return int|null
     */
    public function handle(int $sum, $model_class): ?int
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($sum, $model_class);
        }
        return $sum;
    }
}
