<?php


namespace App\Services\ContentRelevantService\RelevantHandlers;


/**
 * Interface Handler
 * @package App\Services\ContentRelevantService\RelevantHandlers
 */
interface Handler
{
    /**
     * @param Handler $handler
     * @return Handler
     */
    public function setNext(Handler $handler): Handler;

    /**
     * @param int $sum
     * @param $model_class
     * @return int|null
     */
    public function handle(int $sum, $model_class): ?int;
}
