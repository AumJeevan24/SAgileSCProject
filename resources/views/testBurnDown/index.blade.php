<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burn Down Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <div id="burnDownChart" style="width: 900px; height: 500px;"></div>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Day', 'Remaining Hours'],
                @foreach($data as $key => $value)
                    [{{ $key + 1 }}, {{ $value }}],
                @endforeach
            ]);

            var options = {
                title: 'Burn Down Chart',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('burnDownChart'));
            chart.draw(data, options);
        }
    </script>
</body>
</html>
