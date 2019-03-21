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

        $leadsArray = json_decode($response->getBody(), true)['data'];

        while (json_decode($response->getBody(), true)['has_more']) {
            $skip = sizeof($leadsArray);

            $response = $this->client->get(env('CLOSE_API_URL') . '/lead', [
                'auth' => [
                    env('CLOSE_USERNAME'),
                    ''
                ],
                'query' => [
                    'query' => $smartViewQuery,
                    '_limit' => 200,
                    '_skip' => $skip
                ]
            ]);

            $leadsArray = array_merge($leadsArray, json_decode($response->getBody(), true)['data']);
        }
        
        $rawLeads = collect($leadsArray);

        $leadsLifeCycle = [
            'default' => 0,
            'book' => 0,
            'lead_nurturing' => 0,
            'call_scheduled' => 0,
            'called_future_follow_up' => 0,
            'called_closed_converted' => 0,
            'other' => 0
        ];

        $wonOpportunities = [
            'count' => 0,
            'annual_value' => 0
        ];

        $openOpportunities = [
            'count' => 0,
            'annual_value' => 0
        ];

        $emailSequencing = [
            'sequence_name' => null,
            'most_recent_templates_sent' => []
        ];

        $leadNurturingEquivalents = [
            "Lead Nurturing",
            "Lead Well",
            "Lead Well - S",
            "Lead Well - P"
        ];

        $rawLeads->each(function ($lead) use (&$wonOpportunities, &$openOpportunities, &$leadsLifeCycle, &$emailSequencing, $leadNurturingEquivalents) {
            if ($lead['status_label'] == "Default") {
                $leadsLifeCycle['default'] += 1;
            } else if ($lead['status_label'] == "Book") {
                $leadsLifeCycle['book'] += 1;
            } else if (in_array($lead['status_label'], $leadNurturingEquivalents)) {
                $leadsLifeCycle['lead_nurturing'] += 1;
            } else if ($lead['status_label'] == "Call Scheduled") {
                $leadsLifeCycle['call_scheduled'] += 1;
            } else if ($lead['status_label'] == "Called - Future Follow-up") {
                $leadsLifeCycle['called_future_follow_up'] += 1;
            } else if ($lead['status_label'] == "Called - Closed/Converted") {
                $leadsLifeCycle['called_closed_converted'] += 1;
            } else {
                $leadsLifeCycle['other'] += 1;
            }

            $leadOpportunities = collect($lead['opportunities']);

            if ($leadOpportunities->count() > 0) {
                $response = $this->client->get(env('CLOSE_API_URL') . '/activity/email', [
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
                    return isset($email['sequence_name']);
                });

                $mostRecentStepSent = "";

                $sequenceRelatedEmails->each(function ($email) use (&$emailSequencing, &$mostRecentStepSent) {
                    if (!isset($emailSequencing['sequence_name'])) {
                        $emailSequencing['sequence_name'] = $email['sequence_name'];
                    }

                    if ($email['template_name'] > $mostRecentStepSent) {
                        $mostRecentStepSent = $email['template_name'];
                    }
                });

                array_push($emailSequencing['most_recent_templates_sent'], $mostRecentStepSent);
            }

            $wonOpportunitiesCount = 0;
            $wonAnnualValue = 0;
            $openOpportunitiesCount = 0;
            $openAnnualValue = 0;

            $leadOpportunities->each(function ($leadOpp) use (&$wonOpportunitiesCount, &$wonAnnualValue, &$openOpportunitiesCount, &$openAnnualValue) {
                if ($leadOpp['status_type'] == "won") {
                    $wonOpportunitiesCount += 1;
                    $wonAnnualValue += $leadOpp['value']*12/100;
                } else {
                    $openOpportunitiesCount += 1;
                    $openAnnualValue += $leadOpp['value']*12/100;
                }
            });

            $wonOpportunities['count'] += $wonOpportunitiesCount;
            $wonOpportunities['annual_value'] += $wonAnnualValue;
            $openOpportunities['count'] += $openOpportunitiesCount;
            $openOpportunities['annual_value'] += $openAnnualValue;
        });

        $results = [
            'leads_count' => $rawLeads->count(),
            'leads_life_cycle' => $leadsLifeCycle,
            'won_opportunities' => $wonOpportunities,
            'open_opportunities' => $openOpportunities,
            'email_sequencing' => $emailSequencing
        ];

        return $results;
    }
}
