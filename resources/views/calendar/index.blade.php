@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Full Calendar js</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mt-5">FullCalendar js Laravel series with Career Development Lab</h3>
            <div class="col-md-11 offset-1 mt-5 mb-5">
                <div>
                    <button id="addEventBtn" class="btn btn-primary">Add Event</button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title">
                    <span id="titleError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="datetime-local" class="form-control" id="start_date">
                    <span id="startError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="datetime-local" class="form-control" id="end_date">
                    <span id="endError" class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
    $('#addEventBtn').on('click', function() {
        $('#calendarModal').modal('show');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var booking = {!! json_encode($events) !!};

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: booking,
        editable: true,
        eventDrop: function(event) {
            var id = event.id;
            var start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
            var end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

            $.ajax({
                url: "{{ route('calendar.update', '') }}/" + id,
                type: "PATCH",
                dataType: 'json',
                data: { start_date: start_date, end_date: end_date },
                success: function(response) {
                    swal("Success", "Event updated successfully!", "success");
                },
                error: function(error) {
                    console.log(error);
                },
            });
        },
        eventClick: function(event) {
            var id = event.id;

            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: "{{ route('calendar.destroy', '') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        $('#calendar').fullCalendar('removeEvents', response.id);
                        swal("Success", "Event deleted successfully!", "success");
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            }
        },
        selectAllow: function(event) {
            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
        }
    });

    $('#saveBtn').on('click', function() {
        var title = $('#title').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            url: "{{ route('calendar.store') }}",
            type: "POST",
            dataType: 'json',
            data: { title: title, start_date: start_date, end_date: end_date },
            success: function(response) {
                $('#calendarModal').modal('hide'); // Close modal on success
                $('#calendar').fullCalendar('refetchEvents');
                swal("Success", "Event created successfully!", "success");
            },
            error: function(error) {
                if (error.responseJSON.errors) {
                    $('#titleError').html(error.responseJSON.errors.title);
                    $('#startError').html(error.responseJSON.errors.start_date);
                    $('#endError').html(error.responseJSON.errors.end_date);
                }
            },
        });
    });

    $("#calendarModal").on("hidden.bs.modal", function() {
        $('#title').val(''); // Clear input field on modal close
        $('#start_date').val(''); // Clear input field on modal close
        $('#end_date').val(''); // Clear input field on modal close
        $('#titleError').html(''); // Clear error message on modal close
        $('#startError').html(''); // Clear error message on modal close
        $('#endError').html(''); // Clear error message on modal close
    });
});
</script>

</body>
</html>
@endsection
