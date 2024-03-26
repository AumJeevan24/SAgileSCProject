<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary CSS and JavaScript libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <title>FullCalendar Example</title>
</head>
<body>
    <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            // Mocked events data (replace this with your actual event data)
            var events = [
                {
                    title: 'Event 1',
                    start: '2023-12-15'
                },
                {
                    title: 'Event 2',
                    start: '2023-12-18',
                    end: '2023-12-20'
                }
                // Add more events here...
            ];

            // Initialize FullCalendar
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '2023-12-15', // Set default date
                editable: true, // Allow editing events
                eventLimit: true, // Allow "more" link when too many events
                events: events // Load events data
            });
        });
    </script>
</body>
</html>
