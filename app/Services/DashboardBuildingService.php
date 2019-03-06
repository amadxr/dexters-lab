<?php

namespace App\Services;

use App\Models\Experiment;

class DashboardBuildingService
{
    public function buildDashboardInfo($tag = null)
    {
        if ($tag == null) {
            $experiments = Experiment::all();
        } else {
            $experiments = Experiment::whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            })->get();
        }

        $leadsLifeCycle = [
            'default' => 0,
            'book' => 0,
            'lead_nurturing' => 0,
            'call_scheduled' => 0,
            'called_future_follow_up' => 0,
            'called_closed_converted' => 0,
            'other' => 0
        ];

        $opportunities = [
            'count' => 0,
            'annual_value' => 0
        ];

        $experiments->each(function ($experiment) use (&$leadsLifeCycle, &$opportunities) {
            if (isset($experiment->smart_view_id)) {
                $results = json_decode($experiment->results->data, true);

                $leadsLifeCycle['default'] += $results['leads_life_cycle']['default'];
                $leadsLifeCycle['book'] += $results['leads_life_cycle']['book'];
                $leadsLifeCycle['lead_nurturing'] += $results['leads_life_cycle']['lead_nurturing'];
                $leadsLifeCycle['call_scheduled'] += $results['leads_life_cycle']['call_scheduled'];
                $leadsLifeCycle['called_future_follow_up'] += $results['leads_life_cycle']['called_future_follow_up'];
                $leadsLifeCycle['called_closed_converted'] += $results['leads_life_cycle']['called_closed_converted'];
                $leadsLifeCycle['other'] += $results['leads_life_cycle']['other'];

                $opportunities['count'] += $results['won_opportunities']['count'];
                $opportunities['annual_value'] += $results['won_opportunities']['annual_value'];
            }
        });

        $info = [
            'leads_life_cycle' => $leadsLifeCycle,
            'opportunities' => $opportunities
        ];
    }
}
