<?php

namespace App\Services\ContentRelevantService;

use App\Models\Event;
use App\Models\Place;
use App\Services\ContentRelevantService\RelevantHandlers\CreatedAtHandler;
use App\Services\ContentRelevantService\RelevantHandlers\GoogleTrendsHandler;
use App\Services\ContentRelevantService\RelevantHandlers\Handler;
use App\Services\ContentRelevantService\RelevantHandlers\RatingHandler;
use GoogleSearch;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

/**
 * Class ContentRelevantService
 * @package App\Services\ContentRelevantService
 */
class ContentRelevantService
{
    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var string|mixed
     */
    private string $token;

    public const RELEVANT_MODELS = [
        Place::class,
        Event::class,
    ];

    /**
     * ContentRelevantService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = config('google-search')['google_search_token'];
    }

    /**
     * @param string $query
     * @return mixed
     */
    public function getTotalResults(string $query)
    {
        $hash_key = md5($query);
        if ($cache = Cache::get($hash_key)) {
            return $cache;
        }
        $json_response = $this->callGoogleSearchApi($query);
        Cache::rememberForever(
            $hash_key,
            fn() => $json_response->search_information->total_results
        );
        return $json_response->search_information->total_results;
    }

    /**
     *
     */
    public function updateGoogleTrends()
    {
        foreach (self::RELEVANT_MODELS as $model_class) {
            $model_class::all()->each(function ($item) {
                $item->google_trends = $this->getTotalResults($item->google_trends_query);
                $item->save();
            });
        }
    }

    /**
     *
     */
    public function updateRelevance()
    {
        foreach (self::RELEVANT_MODELS as $model_class) {
            $model_instances = $model_class::all();
            $max_trends = $model_instances->pluck('google_trends')->max();
            $model_instances->each(function ($item) use ($model_class, $max_trends) {
                echo '|';
                if ($item->priority != null) {
                    $item->relevance = $item->priority;
                    $item->save();
                } else {
                    $google_trends_handler = new GoogleTrendsHandler($item->google_trends, $max_trends);
                    $created_at_handler = new CreatedAtHandler($item->created_at);
                    $rating_handler = new RatingHandler($item);
                    $google_trends_handler->setNext($created_at_handler)->setNext($rating_handler);
                    $item->relevance = app(ContentRelevantService::class)->countRelevanceWithChain($google_trends_handler, 0, $model_class);
                    $item->save();
                }
            });
            $max_relevance = $model_instances->pluck('relevance')->max();
            $model_instances->each(function ($item) use ($max_relevance) {
                $divider = $max_relevance / 100;
                $item->relevance = ceil($item->relevance / $divider);
                $item->save();
            });
        }
    }

    /**
     * @param string $query
     * @return false|mixed
     */
    public function callGoogleSearchApi(string $query)
    {
        $client = new GoogleSearch($this->token);
        $query = [
            "q" => $query,
            "location" => "Russia"
        ];
        return $client->get_json($query);
    }

    /**
     * @param Handler $handler
     * @param int $init_relevance
     * @param $model_class
     * @return int|null
     */
    public function countRelevanceWithChain(Handler $handler, int $init_relevance, $model_class)
    {
        return $handler->handle($init_relevance, $model_class);
    }
}
