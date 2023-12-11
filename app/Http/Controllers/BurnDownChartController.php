<?php

namespace App\Http\Controllers;
use App\Task;

use Illuminate\Http\Request;

class BurnDownChartController extends Controller
{
    public function index()
    {
        // Dummy data for demonstration
        $tasks = Task::orderBy('created_at')->get(['hours_assigned', 'hours_completed']);

        $data = $this->calculateChartData($tasks);

        return view('testBurnDown.index', compact('data'));
    }

    private function calculateChartData($tasks)
    {
        $estimatedHours = $tasks->sum('hours_assigned');

        $actualHours = 0;
        $data = [];

        foreach ($tasks as $task) {
            $actualHours += $task['hours_completed'];
            $remainingHours = $estimatedHours - $actualHours;
            $data[] = $remainingHours;
        }

        return $data;
    }
}
