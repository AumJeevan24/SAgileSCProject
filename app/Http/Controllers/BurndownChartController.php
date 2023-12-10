<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Sprint;
use App\Task;
use App\Status;

class BurndownChartController extends Controller
{
    public function indexBurnDownchart() 
    {
        $user = auth()->user();
        $teammapping = \App\TeamMapping::where('username', $user->username)->pluck('team_name')->toArray();
        $projects = \App\Project::whereIn('team_name', $teammapping)->get();
        
        return view('Burndownchart.Burndown')->with('pro', $projects);
    }

    public function viewBurndownchart($proj_id) 
    {
        $tasks = Task::where('proj_id', $proj_id)->get();
        $statuses = Status::where('project_id', $proj_id)->get();

        $burndownData = $this->calculateBurndownData($tasks);

        $project = Project::find($proj_id);

        return view('Burndownchart.view')
            ->with('tasks', $tasks)
            ->with('project', $project)
            ->with('statuses', $statuses)
            ->with('burndownData', $burndownData);
    }

    private function calculateBurndownData($tasks)
    {
        $startDate = $tasks->min('start_date');
        $endDate = $tasks->max('end_date');

        $datesWithData = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $tasksOnDate = $tasks->where('start_date', '<=', $date)
                                ->where('end_date', '>=', $date);
            $workload = $tasksOnDate->count();
            $datesWithData[$date->format('Y-m-d')] = $workload;
        }

        return $datesWithData;
    }


}
