<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burn Down Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        #burnDownChart {
            margin: 0 auto; /* Set margin to auto to center the chart horizontally */
        }
    </style>
</head>
<body>

    <div id="burnDownChart" style="width: 900px; height: 500px;"></div>
    <script>

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Day', 'Ideal Hours', 'Actual Hours'], // Add a third column for actual data

                @foreach($idealData as $key => $value)
                @if (!isset($actualData[$key]))
                    [{{ $key }}, {{ $value }}, null],
                @else
                    [{{ $key }}, {{ $value }}, {{ $actualData[$key] }}],
                @endif
                @endforeach


            ]);

            var options = {
                title: 'Burn Down Chart',
                titleTextStyle: { fontSize: 18 },
                curveType: 'none',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Days',
                    viewWindow: {
                        min: 0 // Set the minimum value for the x-axis to 0
                    }
                },
                vAxis: {
                    title: 'Hours',
                    minValue: 0 
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('burnDownChart'));
            chart.draw(data, options);
        }
    </script>

    <div style="text-align: center;">
        <p style="font-size: larger;">
            Start Date: <span style="color: blue;">{{ $start_date }}</span> || End Date: <span style="color: red;">{{ $end_date }}</span>
        </p>
    </div>

</body>
</html>
