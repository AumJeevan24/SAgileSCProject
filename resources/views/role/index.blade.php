@extends('layouts.app2')
@include('inc.success')
<?php
    $themeConfig = app(\App\Services\ThemeConfig::class);
    $styleFile = $themeConfig->getThemeCssFile();
?>

@include("{$styleFile}")
@include('inc.dashboard')
@include('inc.navbar')

@section('content')
    @include('inc.title')
    <br>
    <table>
        <tr>
            <th>Role</th>
            <th>Tools</th>
        </tr>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->role_name }}</td>
                <td>
                    <form action="{{ route('roles.destroy', $role) }}" method="post" class="button-container">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="window.location='{{ route('roles.edit', $role) }}'" class="btn btn-primary">Edit</button>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <br><br>
    <button type="submit"><a href="{{ route('roles.create') }}">Add Role</a></button>
@endsection


