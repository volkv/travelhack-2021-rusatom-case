<?php

namespace App\Services\ContentRelevantService;

use App\Models\Event;
use App\Models\Place;
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
        Event::class,
        Place::class,
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
            fn() => $json_response
        );
        return $json_response->search_information->total_results;
    }

    public function updateGoogleTrends()
    {
        foreach (self::RELEVANT_MODELS as $model_class) {
            $model_class::all()->each(function ($item) {
                $item->google_trends = $this->getTotalResults($item->google_trends_query);
                $item->save();
            });
        }
    }

    public function updateRelevance()
    {
        foreach (self::RELEVANT_MODELS as $model_class) {
            $model_instances = $model_class::whereNotNull('google_trends')->get();
            $model_searches = $model_instances->pluck('google_trends');
            $max_value = $model_searches->max();

            $model_instances->each(function ($item) use ($max_value) {
                $divider = $max_value / 100;
                $item->relevance = ceil($item->google_trends / $divider);
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
}
