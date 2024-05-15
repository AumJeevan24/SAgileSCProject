@extends('layouts.app2')
@include('inc.style')
@include('inc.navbar')

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
    <style>
        body {
    background-color: #f4f7f6;
    font-family: 'Arial', sans-serif;
}

.container {
    margin-top: 50px;
}

.text-center {
    font-family: 'Arial', sans-serif;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 40px;
}

#addEventBtn {
    background-color: #3498db;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

#addEventBtn:hover {
    background-color: #2980b9;
}

#calendar {
    background-color: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.fc-toolbar {
    margin-bottom: 20px;
}

.fc-event-container {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.fc-event {
    background-color: #3498db;
    border: none;
    color: white;
    border-radius: 3px;
    padding: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.fc-event:hover {
    background-color: #2980b9;
}

.modal-header,
.modal-footer {
    border-bottom: none;
    border-top: none;
    background-color: #ecf0f1;
    border-radius: 5px 5px 0 0;
}

.modal-content {
    border-radius: 10px;
}

.modal-title {
    color: #2c3e50;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.btn-secondary {
    background-color: #7f8c8d;
    border-color: #7f8c8d;
}

.btn-secondary:hover {
    background-color: #95a5a6;
    border-color: #95a5a6;
}

.form-label {
    color: #2c3e50;
}

.form-control {
    border-radius: 4px;
    box-shadow: none;
    border-color: #ced4da;
}

.text-danger {
    color: #e74c3c;
}
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">

                <div class="d-flex justify-content-end mb-3">
                    <button id="addEventBtn" class="btn btn-primary">Add Event</button>
                </div>
                <div id="calendar"></div>
            
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

<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Start Date:</strong> <span id="eventDetailStartDate"></span></p>
                <p><strong>End Date:</strong> <span id="eventDetailEndDate"></span></p>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="deleteEventBtn" class="btn btn-danger">Delete Event</button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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

    booking.forEach(function(event) {
        event.color = event.color || '#3498db'; // Set default color if not specified
        event.editable = event.editable !== undefined ? event.editable : true; // Set editable to true by default
    });

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: booking,
        editable: true,
        eventDrop: function(event) {
            if (!event.editable) {
                // If event is not editable, revert the event to its original position
                $('#calendar').fullCalendar('refetchEvents');
            } else {
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
            }
        },
        eventClick: function(event) {
            // Display event details in modal
            $('#eventDetailTitle').text(event.title);
            $('#eventDetailStartDate').text(moment(event.start).format('YYYY-MM-DD HH:mm:ss'));
            $('#eventDetailEndDate').text(moment(event.end).format('YYYY-MM-DD HH:mm:ss'));
            $('#deleteEventBtn').data('event-id', event.id); // Set data attribute for event id
            $('#eventDetailModal').modal('show');
        },
        selectAllow: function(event) {
            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
        },
        eventRender: function(event, element) {
            var iconClass = 'fa fa-calendar'; // Default icon (calendar icon)
            element.find('.fc-content').prepend('<i class="' + iconClass + '"></i>');
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
                $('#calendarModal').modal('hide');
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

    $('#deleteEventBtn').on('click', function() {
        var eventId = $(this).data('event-id');

        $.ajax({
            url: "{{ route('calendar.destroy', '') }}/" + eventId,
            type: "DELETE",
            dataType: 'json',
            success: function(response) {
                $('#calendar').fullCalendar('removeEvents', response.id);
                $('#eventDetailModal').modal('hide');
                swal("Success", "Event deleted successfully!", "success");
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    $("#calendarModal").on("hidden.bs.modal", function() {
        $('#title').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#titleError').html('');
        $('#startError').html('');
        $('#endError').html('');
    });
});
</script>

</body>
</html>
@endsection
