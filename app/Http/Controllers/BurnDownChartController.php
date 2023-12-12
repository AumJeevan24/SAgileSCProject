<?php

namespace App\Http\Controllers;
use App\Task;
use App\Sprint;

use Illuminate\Http\Request;

class BurnDownChartController extends Controller
{
    public function index($sprint_id)
    {
        
        $tasks = Task::where('sprint_id', $sprint_id)->get(['hours_assigned', 'hours_completed','start_date','end_date']);
        $sprint = Sprint::where("sprint_id", $sprint_id)->first();
        $start_date = $sprint->start_sprint;
        $end_date = $sprint->end_sprint;
        $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);

        return view('testBurnDown.index', compact('idealData'),['start_date' => $start_date, 'end_date' => $end_date]);
    }

    private function calculateIdealDataForTasks($tasks,$sprint)
    {
        // $sprintTasks = Task::where('sprint_id', $sprint_id)->get(['start_date', 'end_date']);

        $totalHoursAssigned = 0;

        foreach ($tasks as $task) {
            $startDateTime = strtotime($task->start_date)/ 3600;
            $endDateTime = strtotime($task->end_date)/ 3600;

            // Check if the task falls within the specified date range
            if ($startDateTime <= $endDateTime && $endDateTime >= $startDateTime) {
                // Calculate the total hours within the date range for the task
                $totalHoursAssigned += $this->calculateTotalHoursWithinRange($startDateTime, $endDateTime);
            }
        }


        $idealData = [];
        $start_date = strtotime($sprint->start_sprint);
        $end_date = strtotime($sprint->end_sprint);
        $sprintDuration = max(1, ($end_date - $start_date) / (60 * 60 * 24)); // Avoid division by zero
        //$totalHoursAssigned = $tasks->sum('hours_assigned');
        $idealHoursPerDay =  $totalHoursAssigned / $sprintDuration;

        $currentDate = $start_date;

        $idealData = [$totalHoursAssigned];

        $currentDate = $start_date;

        for ($day = 1; $day < $sprintDuration +1; $day++) {
            $totalHoursAssigned -= $idealHoursPerDay;
            $idealData[] = max(0, $totalHoursAssigned);
            $currentDate += 24 * 60 * 60; // Move to the next day (in seconds)
        }


        return $idealData;
    }

    public function calculateTotalHoursWithinRange($startDateTime, $endDateTime) {
        // Calculate the difference in hours between start and end date
        // $interval = $startDate->diff($endDate);
        $hoursWithinRange = $endDateTime - $startDateTime;
        
        return $hoursWithinRange;
    }
}
