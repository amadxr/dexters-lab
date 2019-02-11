<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    public function index()
    {
        return view('experiments.index');
    }

    public function create()
    {
        return view('experiments.create');
    }

    public function show(Experiment $experiment)
    {
        return view('experiments.show', ['experiment' => $experiment->load('results')]);
    }
}
