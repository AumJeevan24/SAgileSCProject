<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Invitation</title>
</head>
<body>
    <h1>Invitation to Join Our Team</h1>
    <p>Hello,</p>
    <p>You've been invited to join our team!</p>

    <h2>Team Details:</h2>
    <ul>
        <li><strong>Team Name:</strong> Your Team Name</li>
        <li><strong>Your Role:</strong> {{ $role }}</li>
        <!-- Include other relevant team details -->
    </ul>

    <p>Please click on the following link to accept the invitation:</p>
    <p><a href="{{ $acceptanceLink }}">Accept Invitation</a></p>
    <!-- Replace $acceptanceLink with the actual link to accept the invitation -->

    <p>Thank you!</p>
    <p>Your Team</p>
</body>
</html>
