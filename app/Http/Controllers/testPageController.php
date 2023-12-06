<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Task;

class testPageController extends Controller
{
    public function indexTestPage()
    {
        $statuses = Status::where('project_id', "2")->get();
        $tasks = Task::where("proj_id", "2")->get();

        // Group tasks by status id
        $tasksByStatus = [];
        foreach ($tasks as $task) {
            $tasksByStatus[$task->status_id][] = $task;
        }

        return view('testFolder.index', ['statuses' => $statuses, 'tasksByStatus' => $tasksByStatus]);
    }

    
}
