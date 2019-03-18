<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use App\Services\DashboardBuildingService;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    protected $dashboardBuildingService;

    public function __construct(DashboardBuildingService $dashboardService)
    {
        $this->dashboardBuildingService = $dashboardService;
    }

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
        return view('experiments.show', ['experiment' => $experiment->load('tags', 'results')]);
    }

    public function showDashboard(Request $request)
    {
        $dashboardInfo = $this->dashboardBuildingService->buildDashboardInfo($request->input('tag'));

        return view('experiments.dashboard', ['info' => $dashboardInfo]);
    }
}
