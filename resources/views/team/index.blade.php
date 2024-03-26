@extends('layouts.app2')

<?php
    $themeConfig = app(\App\Services\ThemeConfig::class);
    $styleFile = $themeConfig->getThemeCssFile();
?>

@include("{$styleFile}")

@include('inc.success')
@include('inc.dashboard')
@include('inc.navbar')

@section('content')
    @include('inc.title',['title' => 'Your Title'])
    <br>
    <table>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <tr>
            <th>Team Name</th>
            <th>View Members</th>
            <th>Delete</th>
        </tr>

        @forelse($teams as $team)
            <tr>
                <td>{{ $team->team_name }}</td>
                <td><!-- Display associated project name or any other information related to the team --></td>
                <td>
                    <button type="submit">
                        <a href="{{ action('TeamMappingController@index', $team['team_name']) }}">View</a>
                    </button>
                </td>
                <td>
                    <button type="submit">
                        <a href="{{ route('teams.destroy', $team) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this team?');">Delete</a>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No teams found!</td>
            </tr>
        @endforelse
    </table>
    <br><br><br>

    <button type="submit"><a href="{{ route('teams.create') }}">Add Team</a></button>
@endsection
