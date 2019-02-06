<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SmartViewController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        $response = $this->client->get(env('CLOSE_API_URL') . '/saved_search', [
            'auth' => [
                env('CLOSE_USERNAME'),
                ''
            ]
        ]);

        $rawSmartViews = collect(json_decode($response->getBody(), true)['data']);
        $processedSmartViews = $rawSmartViews->map(function ($item) {
            return [
                'id' => $item['id'],
                'title' => $item['name'],
                'query' => $item['query']
            ];
        });

        return $processedSmartViews->toJson();
    }
}
