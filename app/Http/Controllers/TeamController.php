<?php

namespace App\Http\Controllers;
use App\Project;
use App\Team;
use App\User;
use App\Role;
use App\TeamMapping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamInvitation;
use Illuminate\Support\Facades\Log;
use GuzzleHTTP;


class TeamController extends Controller
{
    public function index()
{
    //Get the project where user's team name(s) is the same with project's team name
    $user = \Auth::user();
    $teammapping = \App\TeamMapping::where('username', '=', $user->username)->pluck('team_name')->toArray(); // use pluck() to retrieve an array of team names
    $pro = \App\Project::whereIn('team_name', $teammapping)->get(); // use whereIn() to retrieve the projects that have a team_name value in the array


    $projects = \App\Project::where('team_name', '=', $user->team_name)->get();

    $team = new Team;

    return view ('team.index', ['teams'=>$team->all(), 'projects'=>$projects->all()])
        ->with('title', 'Team')
        ->with('pros', $pro);
}

    
    public function create()
    {
        $user = \Auth::user();

        $team = new Team;
        // $role = new Role;

        // Retrieve the projects with team_name == null 
        $project = Project::whereNull('team_name')->get();

        $current_project = "";

        $roles = Role::all(); // Fetch roles from your database
        // dd($roles); // Add this line to check the $roles variable
        var_dump($roles);

        
        return view('team.create')
            ->with('teams',$team->all())
            ->with('project', $project->all())
            ->with('title', 'Create Team')
            ->with('current_project', $current_project)
            ->with('roles', $roles);

        // return view('team.create', compact('teams', 'project', 'title', 'current_project', 'roles'));

    }
    
    public function store(Request $request)
    {
        $validation = $request->validate([
            'team_name' => 'required|unique:teams',
        ], [
            'team_name.required' => '*The Team Name is required',
            'team_name.unique' => '*There is already an existing team with the same name',
        ]);
    
        $user = \Auth::user();
    
        // Create new team
        $team = new Team();
        $team->team_name = $request->team_name;
        $team->save();
    
        // Find the project and associate it with the team
     
        // Assign the user who created the team as the Project Manager
        $teammapping = new TeamMapping();
        $teammapping->username = $user->username;
        $teammapping->role_name = "Project Manager";
        $teammapping->team_name = $request->team_name;
        $teammapping->save();
    
        return redirect()->route('team.index')->with('success', 'Team has been successfully created! You have been enrolled in the team as Project Manager');
    }
    
    public function show(Team $team)
    {
        $team = new Team();
        return view('team.show')->with ('teams',$team->all());
    }

    public function edit(Team $team)
    {
        $user = \Auth::user();

        $project = new Project; 

        $team = Team::findOrFail($team);

        // Retrieve the projects associated with the current user
        $project = Project::where('user_id', $user->id)->get();
        
        return view('team.edit')
            ->with('project', $project)
            ->with('team', $team);
    }

    public function update(Request $request, Team $team)
    {
        $user = \Auth::user();

        $project = new Project();
        $project = Project::where('user_id', $user->id)->first();
       
        $project->team_name = $request->team_name;
        
        $team->team_name = $request->team_name;
        $team->proj_name = $request->proj_name;
        
        $project->save();
        $team->save(); 
    
        return redirect()->route('team.index', $team)
            ->with('success', 'Team has successfully been updated!');

    }

    public function destroy(Team $team)
    {
        //when delete a team, change the project associated's team_name to null; 

        //delete all the team mappings associated with this team
        $teammapping = \App\Teammapping::where('team_name', $team->team_name)->delete();

        $team->delete();
        return redirect()->route('team.index', $team)
            ->with('success', 'Team has been deleted successfully, Project will remain to exist');

    }

    public function sendMail(){

        $user = \Auth::user();

        $team = new Team;
        // $role = new Role;

        // Retrieve the projects with team_name == null 
        $project = Project::whereNull('team_name')->get();

        $current_project = "";

        $roles = Role::all(); // Fetch roles from your database
        // dd($roles); // Add this line to check the $roles variable
        // var_dump($roles);

        $name = 'bob';
        Mail::to('Amarulakmal@graduate.utm.my')->send(new TeamInvitation($name));

        return view('team.create')
            ->with('teams',$team->all())
            ->with('project', $project->all())
            ->with('title', 'Create Team')
            ->with('current_project', $current_project)
            ->with('roles', $roles);
    }

    public function sendWhatsapp(){
        
    }
    
    

    
}
