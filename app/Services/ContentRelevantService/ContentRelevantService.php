<?php

namespace App\Services\ContentRelevantService;

use GoogleSearch;
use GuzzleHttp\Client;

class ContentRelevantService
{
    private Client $client;
    private string $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = config('google-search')['google_search_token'];
    }

    public function getTotalResults(string $query)
    {
        $json_response = $this->callApi($query);
        return $json_response->search_information->total_results;
    }

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
