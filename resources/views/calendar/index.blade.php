@extends('layouts.app2')
@include('inc.style') <!-- Include any other stylesheets needed -->

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('calendar.create') }}" class="btn btn-primary">Add Event</a>
            </div>
            <div id="calendar"></div>

        </div>
    </div>
</div>

@include('inc.navbar') <!-- Include your navbar if it's not already included -->

@endsection

@section('page-script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-o9DDUiYHCL4y9/bInkrWw/zrlVsq+v2u8Iu3BI5eqj6O3XftzweLwJ2pPwznn0g+DLFm9kRIW21cmXhHJjV/JA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css" integrity="sha512-WrA/v9myhSu4DyvEqeVpFbgsA8kC5Ql+8tUwm0XNK1e+4EZ1iYtthRk1W2aAiv3ldNKKy5EyCjPqy5EwR4IjDw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<style>
    /* FullCalendar */
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        background-color: #fff;
        border: 1px solid #ddd; /* Add border */
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .fc-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: #F8FAF8;
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .fc-toolbar h2 {
        font-size: 1.8rem; /* Larger font size */
        margin-bottom: 0;
        color: #574956;
    }

    .fc-button {
        background-color: #3f58b0;
        border-color: #3f58b0;
        color: #fff;
        margin: 0 5px;
        border-radius: 5px;
        display: inline-flex; /* Ensure buttons display inline */
        align-items: center; /* Center content vertically */
        padding: 8px 12px; /* Adjust padding as needed */
    }

    .fc-button:hover {
        background-color: #2c3e6b;
        border-color: #2c3e6b;
    }

    /* Adjustments for today and month/week/day navigation */
    .fc-center h2 {
        font-size: 1.5rem; /* Adjust font size for month/week/day header */
        margin: 0;
    }

    .fc-left,
    .fc-right {
        display: flex;
        align-items: center;
    }

    .fc-left .fc-button-group,
    .fc-right .fc-button-group {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .fc-left .fc-button,
    .fc-right .fc-button {
        padding: 8px 12px; /* Adjust padding as needed */
    }

    /* Font Awesome Icons */
    .fc-prev-button .fc-icon:before,
    .fc-next-button .fc-icon:before {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 1rem; /* Adjust icon size as needed */
    }

    .fc-prev-button .fc-icon:before {
        content: '\f053'; /* FontAwesome icon for previous (chevron left) */
    }

    .fc-next-button .fc-icon:before {
        content: '\f054'; /* FontAwesome icon for next (chevron right) */
    }
</style>

<script>
$(document).ready(function() {
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
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this event!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('calendar.destroy', '') }}/" + event.id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            swal("Success", "Event deleted successfully!", "success");
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                } else {
                    swal("Your event is from Tasks!");
                }
            });
        },
        selectAllow: function(event) {
            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
        },
        eventRender: function(event, element) {
            var iconClass = 'fa fa-calendar';
            element.find('.fc-content').prepend('<i class="' + iconClass + '"></i>');
        }
    });
});
</script>

@endsection
