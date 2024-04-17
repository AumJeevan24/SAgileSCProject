<?php

namespace App\Http\Controllers;

use App\Priority;
use App\UserStory;
use App\Status;
use App\SecurityFeature;
use App\PerformanceFeature;
use App\Project;
use App\Role;
use App\Mapping;
use App\Team;
use App\TeamMapping;
use App\Sprint;
use App\Task;
use App\Http\Controllers\Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Response;

class UCDController extends Controller
{
    public function index($sprint_id)
    {
        $user = \Auth::user();
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();
        $project = Project::where('proj_name', $sprint->proj_name)->first();
        $userstory = \App\UserStory::where('sprint_id', '=', $sprint_id)->get();
        $sprint_name = str_replace(' ', '', $sprint->sprint_name);

        $userstories = $userstory->pluck('user_story');

        $url = 'http://127.0.0.1:7000/ucd/';

        $jsonData = [
            'user_stories' => $userstories,
            'system_name' => $sprint_name
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->withBody(json_encode($jsonData), 'application/json')->post($url);

        if ($response->successful()) {
            $imageData = $response->body();

            // Create a data URI for the image
            $dataUri = 'data:image/png;base64,' . base64_encode($imageData);

            $errorMsg = '';
        } else {
            // Request failed
            $dataUri = '';

            if ($response->body() == 'Invalid payload format: user_stories need to be in a list') {
                $errorMsg = 'Error: No User Stories detected.';
            }
            if ($response->body() == 'Invalid payload format: some (or all) items in user_stories are not strings') {
                $errorMsg = 'Error: User Stories identified as not being strings.';
            }
            if ($response->body() == 'Invalid payload format: system_name must be a string and cannot be empty') {
                $errorMsg = 'Error: Sprint name cannot be empty.';
            }
        }


        return view('ucd.index')
            ->with('title', 'UCD for ' . $sprint->sprint_name)
            ->with('sprints', $sprint)
            ->with('dataUri', $dataUri)
            ->with('response', $response)
            ->with('userstories', $userstories)
            ->with('errorMsg', $errorMsg);

        // return view('ucd.index');
    }
}