<?php

namespace App\Http\Controllers\Api;

use App\Models\Experiment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperiment;
use App\Http\Resources\ExperimentResource;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    public function index()
    {
        $experiments = Experiment::orderBy('created_at', 'desc')->get();

        return ExperimentResource::collection($experiments);
    }

    public function show(Experiment $experiment)
    {
        return new ExperimentResource($experiment);
    }

    public function store(StoreExperiment $request)
    {
        $experiment = Experiment::create($request->all());

        return new ExperimentResource($experiment);
    }
}
