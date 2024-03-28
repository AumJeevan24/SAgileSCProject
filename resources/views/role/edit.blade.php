@extends('layouts.app2')
@include('inc.style')
@include('inc.navbar')

@section('content')
    <br><br><br>
    <form action="{{ route('roles.update', $role) }}" method="post">
        @csrf
        @method('PATCH')
        
        <label for="role_name">Role Name:</label>
        <input type="text" name="role_name" style="margin-left:2.5em" value="{{ $role->role_name }}">
        <div class="error"><font color="red" size="2">{{ $errors->first('role_name') }}</p></font></div>
        <br><br><br>

        

        
        <br><br>

        <button type="submit">Update</button>
    </form>

    

    <br><br><br>
@endsection




