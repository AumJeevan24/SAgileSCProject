<?php

namespace App\Http\Controllers;
use App\Task;
use App\Sprint;
use App\Status;

use Illuminate\Http\Request;

class BurnDownChartController extends Controller
{
    public function index($proj_id, $sprint_id)
    {
        
        $tasks = Task::where('sprint_id', $sprint_id)->get(['start_date','end_date','status_id']);
        $sprint = Sprint::where("sprint_id", $sprint_id)->first();
        $statuses = Status::where('project_id', $proj_id)->get();
        $start_date = $sprint->start_sprint;
        $end_date = $sprint->end_sprint;
        $currentDate = now();
        //$actualData = array(144,144,144,); //panggil func cal actual line
        //$actualData = [];

        // $actualData =  $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];
        // $actualData =  $this->calculateIdealLine($start_date,$end_date,$actualData);
        // $sprint->actualHoursPerDay = $actualData;
        // $sprint->save();

        if ($this->isBeforeStartDate($start_date)) {
            $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
            // Update Sprint model with the calculated idealData
            $sprint->idealHoursPerDay = $idealData;
            $sprint->save();
            //$actualData = array(144,144,144,); 
            $actualData = array($this->calcTotalHoursAssigned($tasks));
            

            var_dump($idealData);
            var_dump($actualData);
        
            return view('testBurnDown.index', compact('idealData','actualData'),['start_date' => $start_date, 'end_date' => $end_date]);

        }else if ($this->isBeforeEndDate($end_date)){
            //$idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];
            if(empty($idealData)){
                $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
                // Update Sprint model with the calculated idealData
                $sprint->idealHoursPerDay = $idealData;
                $sprint->save();
            }

            $actualData =  $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];
            $actualData =  $this->calculateActualLine($start_date,$end_date,$actualData,$tasks,$statuses);
            $sprint->actualHoursPerDay = $actualData;
            $sprint->save();
    
            //$actualData = array(145,145,145,); 
            var_dump($idealData);
            var_dump($actualData);

            return view('testBurnDown.index', compact('idealData','actualData'),['start_date' => $start_date, 'end_date' => $end_date]);
        }else{
            $idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];
            $actualData = $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];

            if(empty($actualData)){
                $actualData = array($this->calcTotalHoursAssigned($tasks));
            }

            //$actualData = array(146,146,146,); 

            var_dump($idealData);
            var_dump($actualData);

            return view('testBurnDown.index', compact('idealData','actualData'),['start_date' => $start_date, 'end_date' => $end_date]);

        }

    }

    public function isBeforeStartDate($startDate)
    {
        $currentDate = now(); // Laravel's now() function gets the current date and time
        return strtotime($currentDate) < strtotime($startDate);
    }

    public function isBeforeEndDate($end_date)
    {
        $currentDate = now(); // Laravel's now() function gets the current date and time
        return strtotime($currentDate) < strtotime($end_date);
    }

    public function calculateIdealDataForTasks($tasks,$sprint)
    {
        // $sprintTasks = Task::where('sprint_id', $sprint_id)->get(['start_date', 'end_date']);

        $totalHoursAssigned = $this ->calcTotalHoursAssigned($tasks);

        $idealData = [];
        $start_date = strtotime($sprint->start_sprint);
        $end_date = strtotime($sprint->end_sprint);
        $sprintDuration = max(1, ($end_date - $start_date) / (60 * 60 * 24)); // Avoid division by zero

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

    public function calcTotalHoursAssigned($tasks){

        $totalHoursAssigned =0;
        
        foreach ($tasks as $task) {
            $startDateTime = strtotime($task->start_date)/ 3600;
            $endDateTime = strtotime($task->end_date)/ 3600;

            // Check if the task falls within the specified date range
            if ($startDateTime <= $endDateTime && $endDateTime >= $startDateTime) {
                // Calculate the total hours within the date range for the task
                $totalHoursAssigned += $this->calculateTotalHoursWithinRange($startDateTime, $endDateTime);
            }
        }

        return $totalHoursAssigned;

    }

    public function calculateTotalHoursWithinRange($startDateTime, $endDateTime) {
        // Calculate the difference in hours between start and end date
        // $interval = $startDate->diff($endDate);
        $hoursWithinRange = $endDateTime - $startDateTime;
        
        return $hoursWithinRange;
    }

    public function calculateActualLine($startDate, $endDate, $actualData, $tasks, $statuses)
    {
        $startDateTime = strtotime($startDate);
        $endDateTime = strtotime($endDate);
        $currentDate = now();

        $daysDifferenceStartCurrent = floor((strtotime($currentDate) - $startDateTime) / (60 * 60 * 24));

        $totalHoursAssigned = $this ->calcTotalHoursAssigned($tasks);

        if(empty($actualData)){
            $actualData = [$totalHoursAssigned];
        }

        $taskDone = collect(); // Initialize an empty collection
        
        foreach($tasks as $task){

            $status = $statuses->firstWhere('id', $task->status_id);

            if($status->title == "done"){
                $taskDone->add($task); // Add the task to the collection
            }

        }

        // Loop through the tasks to find the one with status title "done"
        // $tasks = Task::where('start_date', '>=', $startDate)
        //             ->where('end_date', '<=', $endDate)
        //             ->whereHas('status', function ($query) {
        //                 $query->where('title', 'Done');
        //             })
        //             ->get(['start_date', 'end_date']);

        // Check if there are no done tasks
        if ($taskDone->isEmpty()) {
            $doneTaskHours = 0;
        } else {
            $doneTaskHours = 0;
            foreach ($taskDone as $task) {
                $doneTaskHours += $this->calculateTotalHoursWithinRange(strtotime($task->start_date), strtotime($task->end_date));
            }
        }

        $totalHoursLeft = $totalHoursAssigned - $doneTaskHours;

        $curDay = count($actualData);
        $lastArray = count($actualData) - 1;
        $lastDay = end($actualData);

        if( $daysDifferenceStartCurrent > 0 && $curDay < $daysDifferenceStartCurrent){

            for ($i = 0; $i < $daysDifferenceStartCurrent; $i++) {
                $actualData[] = $lastDay;
            }            
        }
        else{
            $actualData[$lastArray] = $totalHoursLeft;
        }

        return $actualData;
    }

 }
