@extends('layouts.app2')
@include('inc.navbar')

@section('content')
    <br><br><br>
    <form action="{{ route('teams.update', $team->id) }}" method="post">
        @csrf
        
        Team Name: <input type="text" name="team_name" style="margin-left:2.5em" value="{{ $team->team_name }}">
        <br><br><br>
 
        <!-- Rest of your form elements... -->

        <!-- Button to Add Team Members -->
        <button type="button" id="addMember">Add Team Member</button>

        <!-- Div to Display Added Team Members -->
        <div id="teamMembers">
            <!-- Here, JavaScript will dynamically add the team members' names -->
        </div>

        <!-- Submit Button -->
        <button type="submit">Update</button>
        <button type="submit"><a href="{{ route('team.index') }}">Cancel</a></button>
    </form>

    <!-- Include Script -->
    <script>
        $(document).ready(function() {
            let memberCount = 0;

            $('#addMember').on('click', function() {
                memberCount++;
                $('#teamMembers').append(
                    `<div>
                        <input type="text" name="team_members[]" placeholder="Team Member ${memberCount}">
                        <button type="button" class="removeMember">Remove</button>
                    </div>`
                );
            });

            // Remove a team member field
            $('#teamMembers').on('click', '.removeMember', function() {
                $(this).parent().remove();
            });
        });
    </script>
@endsection
