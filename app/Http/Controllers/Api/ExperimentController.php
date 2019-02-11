<?php

namespace App\Http\Controllers\Api;

use App\Models\Experiment;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignSmartView;
use App\Http\Requests\StoreExperiment;
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
        $experiments = Experiment::with(['results'])->orderBy('created_at', 'desc')->get();

        return ExperimentResource::collection($experiments);
    }

    public function show(Experiment $experiment)
    {
        return new ExperimentResource($experiment);
    }

    public function store(StoreExperiment $request)
    {
        $experiment = Experiment::create($request->only([
            'title',
            'background',
            'falsifiable_hypothesis',
            'details'
        ]));

        return new ExperimentResource($experiment->load('results'));
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

        return new ExperimentResource($experiment->load('results'));
    }
}
