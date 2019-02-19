<?php

namespace App\Http\Controllers\Api;

use App\Models\Experiment;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignSmartView;
use App\Http\Requests\StoreExperiment;
use App\Http\Requests\UpdateResults;
use App\Http\Resources\ExperimentResource;
use App\Services\ExperimentResultsService;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    protected $experimentResultsService;

    public function __construct(ExperimentResultsService $resultsService)
    {
        $this->experimentResultsService = $resultsService;
    }

    public function index()
    {
        $experiments = Experiment::with(['tags', 'results'])->orderBy('created_at', 'desc')->get();

        return ExperimentResource::collection($experiments);
    }

    public function store(StoreExperiment $request)
    {
        $tagIds = [];

        collect($request->tags)->each(function ($tag) use (&$tagIds) {
            if ($tag['id'] != null) {
                array_push($tagIds, $tag['id']);
            } else {
                $newTag = Tag::create([
                    'name' => $tag['name']
                ]);

                array_push($tagIds, $newTag->id);
            }
        });

        $experiment = Experiment::create($request->only([
            'title',
            'background',
            'falsifiable_hypothesis'
        ]));

        $experiment->tags()->sync($tagIds);

        return new ExperimentResource($experiment->load('tags', 'results'));
    }

    public function assignSmartView(AssignSmartView $request)
    {
        $experiment = Experiment::findOrFail($request->id);
        $experiment->smart_view_id = $request->smart_view_id;
        $experiment->smart_view_query = $request->smart_view_query;

        $results = $this->experimentResultsService->buildResults($experiment->smart_view_query);

        $experiment->results()->create([
            'leads_count' => $results['leadsCount'],
            'opportunities_count' => $results['opportunities']['count'],
            'opportunities_value' => $results['opportunities']['amount']
        ]);

        $experiment->save();

        return new ExperimentResource($experiment->load('tags', 'results'));
    }

    public function updateResults(UpdateResults $request)
    {
        $experiment = Experiment::findOrFail($request->id);

        if (isset($experiment->smart_view_query)) {
            $results = $this->experimentResultsService->buildResults($experiment->smart_view_query);

            $experiment->results()->create([
                'leads_count' => $results['leadsCount'],
                'opportunities_count' => $results['opportunities']['count'],
                'opportunities_value' => $results['opportunities']['amount']
            ]);

            $experiment->save();
        }

        return new ExperimentResource($experiment->load('tags', 'results'));
    }
}
