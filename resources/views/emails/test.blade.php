<!DOCTYPE html>
<html>
<head>
    <title>Reminder Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #4CAF50;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .table td {
            background-color: #fff;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Upcoming Event Reminder</h1>
        </div>
        <div class="content">
            <h2>Dear User,</h2>
            <p>We wanted to remind you that the following event is about to due:</p>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Calendar Task</td>
                            <td>13/6/2024</td>
                            <td>15/6/2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p>Please ensure you complete any necessary preparations before the due date.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} sAgile. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
