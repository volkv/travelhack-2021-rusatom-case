<?php

namespace App\Services\ContentRelevantService;

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
        $json_response = $this->callApi($query);
        Cache::rememberForever(
            $hash_key,
            fn() => $json_response
        );
        return $json_response->search_information->total_results;
    }

    /**
     * @param string $query
     * @return false|mixed
     */
    public function callApi(string $query)
    {
        $client = new GoogleSearch($this->token);
        $query = [
            "q" => $query . " событие мурманск",
            "location" => "Russia"
        ];
        return $client->get_json($query);
    }
}
