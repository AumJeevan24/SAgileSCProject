<?php

namespace App\Http\Controllers;

use App\Role;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access this page');
        }
    
        $teammapping = \App\TeamMapping::where('username', $user->username)->pluck('team_name')->toArray();
        $pro = Project::whereIn('team_name', $teammapping)->get();
    
        // Retrieve roles based on team name
        $roles = Role::all();
        
        return view('role.index', [
            'roles' => $roles,
            'pro' => $pro,
            'title' => 'Role'
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create')
            ->with('title', 'Create Role');
    }


    public function store(Request $request)
{
    $validatedData = $request->validate(Role::rules());

    // If validation passes, attempt to create the role
    try {
        $role = Role::create([
            'role_name' => $validatedData['role_name']
        ]);

        // Role created successfully
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    } catch (\Exception $e) {
        
        // Handle any exceptions or errors that occur during role creation
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create role']);
    }
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $user = \Auth::user();
        return view('role.edit')
            ->with('roles', Role::all())
            ->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        $roles = new Role;
        return redirect()->route('role.index' ,['roles'=>$roles->all()])
            ->with('title', 'Role')
            ->with('success', 'Role has successfully been deleted!');    
    }


    public function update(Request $request, Role $role)
{
    $validatedData = $request->validate([
        'role_name' => [
            'required',
            Rule::unique('roles')->ignore($role->id),
        ],
    ]);

    try {
        $role->update([
            'role_name' => $validatedData['role_name'],
            // Update permissions here based on form input
            'permissions' => $request->input('permissions') ?? []
        ]);

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    } catch (\Exception $e) {
        \Log::error('Failed to update role: ' . $e->getMessage());

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update role']);
    }
}



    
}

