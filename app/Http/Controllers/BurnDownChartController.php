<?php

namespace App\Http\Controllers;
use App\Task;
use App\Sprint;
use App\Status;
use Illuminate\Http\Request;
use App\User;

class BurnDownChartController extends Controller
{
    public function index($proj_id, $sprint_id)
    {
        
        $tasks = Task::where('sprint_id', $sprint_id)->get(['start_date','end_date','status_id']);
        $sprint = Sprint::where("sprint_id", $sprint_id)->first();
        $statuses = Status::where('project_id', $proj_id)->get();
        $user = \Auth::user();
        $countryName = $user->country;
        var_dump($countryName);

        $start_date = $sprint->start_sprint;
        $end_date = $sprint->end_sprint;

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
            $idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];
            if(empty($idealData)){
                $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
                // Update Sprint model with the calculated idealData
                $sprint->idealHoursPerDay = $idealData;
                $sprint->save();
            }
            $dayZero = reset($idealData);

            $actualData =  $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];
            $actualData =  $this->calculateActualLine($start_date,$end_date,$actualData,$tasks,$statuses,$dayZero);
            $sprint->actualHoursPerDay = $actualData;
            $sprint->save();
    
            //$actualData = array(96,120,72,72,48,0); 
            var_dump($idealData);
            var_dump($actualData);

            return view('testBurnDown.index', compact('idealData','actualData'),['start_date' => $start_date, 'end_date' => $end_date]);
        }else{
            $idealData = $sprint->idealHoursPerDay ? json_decode($sprint->idealHoursPerDay, true) : [];
            $actualData = $sprint->actualHoursPerDay ? json_decode($sprint->actualHoursPerDay, true) : [];

            if(empty($idealData)){
                $idealData = $this->calculateIdealDataForTasks($tasks,$sprint);
                // Update Sprint model with the calculated idealData
                $sprint->idealHoursPerDay = $idealData;
                $sprint->save();
            }

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
        $currentDate = now()->timezone('Asia/Kuala_Lumpur');
        // Laravel's now() function gets the current date and time
        return strtotime($currentDate) < strtotime($startDate);
    }

    public function isBeforeEndDate($end_date)
    {
        $currentDate = now()->timezone('Asia/Kuala_Lumpur');
        // Laravel's now() function gets the current date and time
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

        $idealData[] = $totalHoursAssigned;
        $idealData[] = $totalHoursAssigned;


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
        $hoursWithinRange = $endDateTime - $startDateTime;
        
        return $hoursWithinRange;
    }

    public function calculateActualLine($startDate, $endDate, $actualData, $tasks, $statuses,$dayZero)
    {
        $startDateTime = strtotime($startDate);
        $endDateTime = strtotime($endDate);
        $currentDate = now()->timezone('Asia/Kuala_Lumpur');

        $daysDifferenceStartCurrent = floor((strtotime($currentDate) - $startDateTime) / (60 * 60 * 24));

        $totalHoursAssigned = $this ->calcTotalHoursAssigned($tasks);

        if(empty($actualData)){
            //$actualData = [$totalHoursAssigned];
            $actualData[] = $dayZero;
            $actualData[] = $totalHoursAssigned;
            //$daysDifferenceStartCurrent = $daysDifferenceStartCurrent + 1;
        }

        $taskDone = collect(); // Initialize an empty collection
        $taskNotDone = collect();
        
        foreach($tasks as $task){

            $status = $statuses->firstWhere('id', $task->status_id);
            $statusTitle = strtolower($status->title);
            
            if($statusTitle == "done"){
                $taskDone->add($task); // Add the task to the collection
            }
            else{
                $taskNotDone->add($task);;
            }

        }

        // Check if there are no done tasks
        $doneTaskHours = 0;

        if (!$taskDone->isEmpty()) {
            //$doneTaskHours = 0;
            foreach ($taskDone as $task) {
                $startDateTimeHours = strtotime($task->start_date)/ 3600; //hours
                $endDateTimeHours = strtotime($task->end_date)/ 3600;
                $startDateTime = $task->start_date;
               
                //$doneTaskHours += $this->calculateTotalHoursWithinRange($startDateTime, $endDateTime);
                
                $currentDateHours = $currentDate->timestamp / 3600;

                var_dump("Start: " . $startDateTimeHours . ", End: " . $endDateTimeHours . ", Current: " . $currentDateHours );

                if($this->isBeforeStartDate($startDateTime)){
                    $doneTaskHours += $this->calculateTotalHoursWithinRange($startDateTimeHours, $endDateTimeHours);
                    var_dump("Inside b4");
                }else{
                    $doneTaskHours += $this->calculateTotalHoursWithinRange($startDateTimeHours, $currentDateHours);
                    var_dump("Inside after");
                }
            }
            
            // $daysDifferenceStartCurrent = $daysDifferenceStartCurrent + 1;
        } 

        var_dump("Calculated doneTaskHours: " . $doneTaskHours);
        var_dump("Calculated totalHoursAssigned: " . $totalHoursAssigned);
        $totalHoursLeft = $totalHoursAssigned - $doneTaskHours;
        var_dump("Calculated totalHoursLeft: " . $totalHoursLeft);

        if($taskNotDone->isEmpty()){
            $totalHoursLeft = 0;
        }

        $countArray = count($actualData);
        $lastArray = count($actualData) - 1;
        $lastDay = end($actualData);
        $fillArray =  abs($daysDifferenceStartCurrent - $countArray);
        var_dump("countArray: " . $countArray);
        var_dump("daysDifferenceStartCurrent: " . $daysDifferenceStartCurrent);
        var_dump("fillArray: " . $fillArray);

        $dayDifTemp = $daysDifferenceStartCurrent;

        if($dayDifTemp == 1){
            $dayDifTemp = $dayDifTemp + 1;
        }

        //betulkan ni
        if ($countArray <= $dayDifTemp) {

            if($countArray == 2){
                for ($i = 0; $i < $daysDifferenceStartCurrent; $i++) {
                    $actualData[] = $lastDay;
                }
                var_dump("inside countArray ");
            }
            else{
                for ($i = 0; $i < $fillArray; $i++) {
                    $actualData[] = $lastDay;
                }
                var_dump("inside fillArray ");
            }

        }

        $actualData[$lastArray] = $totalHoursLeft;
        var_dump("lastArray: " . $actualData[$lastArray]);

        return $actualData;
    }
    

}
