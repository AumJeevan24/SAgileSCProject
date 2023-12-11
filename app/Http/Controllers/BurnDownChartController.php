<?php

namespace App\Http\Controllers;
use App\Task;
use App\Sprint;

use Illuminate\Http\Request;

class BurnDownChartController extends Controller
{
    public function index($sprint_id)
    {
        
        $tasks = Task::orderBy('created_at')->get(['hours_assigned', 'hours_completed']);
        $sprint = Sprint::where("sprint_id", $sprint_id)->first();

        //$data = $this->calculateChartData($tasks);
        $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);

        // return view('testBurnDown.index', compact('data'));
        //return response()->json(['idealData' => $idealData]);
        return view('testBurnDown.index', compact('idealData'));
    }

    private function calculateIdealDataForTasks($tasks,$sprint)
    {
        

    //     $actualHours = 0;
    //     $data = [];

    //     foreach ($tasks as $task) {
    //         $actualHours += $task['hours_completed'];
    //         $remainingHours = $estimatedHours - $actualHours;
    //         $data[] = $remainingHours;
    //     }

    //     return $data;

        $idealData = [];
        $start_date = strtotime($sprint->start_sprint);
        $end_date = strtotime($sprint->end_sprint);
        $sprintDuration = max(1, ($end_date - $start_date) / (60 * 60 * 24)); // Avoid division by zero
        $totalHoursAssigned = $tasks->sum('hours_assigned');
        $idealHoursPerDay =  $totalHoursAssigned / $sprintDuration;

        $currentDate = $start_date;

        for ($day = 0; $day < $sprintDuration; $day++) {
            $totalHoursAssigned -= $idealHoursPerDay;
            $idealData[] = $totalHoursAssigned;
            $currentDate += 24 * 60 * 60; // Move to the next day (in seconds)
        }

        return $idealData;
    }
}
