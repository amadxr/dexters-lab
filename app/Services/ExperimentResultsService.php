<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExperimentResultsService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function buildResults($smartViewQuery)
    {
        $response = $this->client->get(env('CLOSE_API_URL') . '/lead', [
            'auth' => [
                env('CLOSE_USERNAME'),
                ''
            ],
            'query' => [
                'query' => $smartViewQuery,
                '_limit' => 200
            ]
        ]);

        $rawLeads = collect(json_decode($response->getBody(), true)['data']);

        $opportunities = [
            'count' => 0,
            'amount' => 0
        ];

        /*$emailSequencing = [
            'openRate' => 0
        ];*/

        $rawLeads->each(function ($lead) use (&$opportunities) {
            $leadOpportunities = collect($lead['opportunities']);

            $count = $leadOpportunities->count();
            $amount = 0;

            if ($count > 0) {
                $leadOpportunities->each(function ($leadOpp) use (&$amount) {
                    $amount += $leadOpp['value']/100;
                });
            }

            $opportunities['count'] += $count;
            $opportunities['amount'] += $amount;
            
            /*$response = $this->client->get(env('CLOSE_API_URL') . '/activity/email', [
                'auth' => [
                    env('CLOSE_USERNAME'),
                    ''
                ],
                'query' => [
                    'lead_id' => $lead['id']
                ]
            ]);

            $rawEmailActivity = collect(json_decode($response->getBody(), true)['data']);

            $sequenceRelatedEmails = $rawEmailActivity->filter(function ($email) {
                return isset($email['sequence_id']);
            });

            $stepsSent = $sequenceRelatedEmails->count();*/
        });

        $results = [
            'leadsCount' => $rawLeads->count(),
            'opportunities' => $opportunities
        ];

        return $results;
    }
}
