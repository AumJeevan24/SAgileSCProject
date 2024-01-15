<?php

namespace App\Http\Controllers;

use App\Sprint;
use Illuminate\Http\Request;
use App\Status;
use App\Task;
use App\Project;
use App\Http\Controllers\Auth;
use App\User;
use App\UserStory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KanbanController extends Controller
{
    public function kanbanIndex($proj_id, $sprint_id)
    {
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();
        $project = Project::where('id', $proj_id)->first();
        $statuses = Status::where('project_id', $proj_id)->get();
        $tasks = Task::where("proj_id", $proj_id)->where("sprint_id", $sprint_id)->get();

        // Group tasks by status id
        $tasksByStatus = [];
        foreach ($tasks as $task) {
            $tasksByStatus[$task->status_id][] = $task;
        }

        return view('kanban.index', ['statuses' => $statuses, 'tasksByStatus' => $tasksByStatus, 'sprint' => $sprint, 'project' => $project]);
    }

    public function createStatus(Request $request)
    {
        // validate the request
        // $validation = $request->validate([
        //     'statusName' => 'required|unique:statuses,title',
        //     'sprintID' => 'required|exists:sprints,id',
        // ], [
        //     'statusName.required' => '*The Status Name is required',
        //     'statusName.unique' => '*There is already an existing Status with the same name',
        //     'sprintID.required' => '*The Sprint ID is required',
        //     'sprintID.exists' => '*The specified Sprint ID does not exist',
        // ]);

        // Extract data from the request
        $newLaneName = $request->input('statusName');
        $sprintID = $request->input('sprintID');
        $projectID = $request->input('project_id');

        // Create an instance of StatusController
        $statusController = new StatusController();

        // Call the store method of StatusController
       $statusController->store(new Request([
            'title' => $newLaneName,
            'project_id' => $projectID,
        ]));

        // Return the modified response
        return response()->json(['message' => 'Status created successfully', 'reload' => true]);
    }

    // Update the lane name
    public function updateStatus(Request $request)
    {
        $statusId = $request->input('statusId');
        $newName = $request->input('newName');

        try {
            $status = Status::findOrFail($statusId);
            $status->title = $newName;
            $status->slug = $newName;
            $status->save();

            return response()->json(['message' => 'Lane name updated successfully', 'reload' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating lane name'], 500);
        }
    }

    // Update task positions
    public function updateTaskStatus(Request $request)
    {
        $positions = $request->input('positions');

        try {
            foreach ($positions as $position) {
                $task = Task::find($position['taskId']);
                $task->status_id = $position['statusId'];
                $task->order = $position['position'];
                $task->save();
            }

            return response()->json(['message' => 'Task positions saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving task positions'], 500);
        }
    }

    // Delete a lane
    public function deleteStatus(Request $request)
    {
        $laneId = $request->input('laneId');

        try {
            // Find the order of the lane to be deleted
            $laneOrder = Status::where('id', $laneId)->value('order');

            // Find and delete the tasks associated with the lane using the Task model
            Task::where('status_id', $laneId)->delete();

            // Delete the lane
            Status::destroy($laneId);

            return response()->json(['success' => true, 'message' => 'Lane and associated tasks deleted successfully', 'reload' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error deleting lane and associated tasks'], 500);
        }
    }

    // Redirect to Create Task Page
    public function createTask(Request $request)
    {
        $sprintId = $request->input('sprintId');
        $statusId = $request->input('statusId');
        $sprint = Sprint::where('sprint_id', $sprintId)->first();
        $sprintProjName = $sprint->proj_name;
        $sprintProj = Project::where('proj_name', $sprintProjName)->first();
        $sprintProjId = $sprintProj->id;

        $userStories = UserStory::where('sprint_id', $sprintId)->get();
        $userList = User::all();

        return view('kanban.addTask', [
            'userStories' => $userStories,
            'userList' => $userList,
            'sprint_id' => $sprintId,
            'status_id' => $statusId,
            'sprintProjId' => $sprintProjId,
            'sprint' => $sprint
        ]);    
    }

    // Delete a task
    public function deleteTask(Request $request)
    {
        $taskId = $request->input('taskId');

        try {
            // Find and delete the task
            Task::destroy($taskId);

            return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error deleting task'], 500);
        }
    }

    // Redirect to updateTaskPage
    public function updateTaskPage($taskId)
    {
        $task = Task::findOrFail($taskId);
        $userList = User::all();
        $status_id = $task->status_id;
        $sprint_id = $task->sprint_id;
        $sprintProjId = $task->proj_id;  // Add this line
        $userStories = UserStory::where('sprint_id', $task->sprint_id)->get();
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();

        return view('kanban.updateTask', [
            'task' => $task,
            'userStories' => $userStories,
            'userList' => $userList,
            'status_id' => $status_id,
            'sprint_id' => $sprint_id,
            'sprintProjId' => $sprintProjId,  
            'sprint' => $sprint
        ]);
    }
}