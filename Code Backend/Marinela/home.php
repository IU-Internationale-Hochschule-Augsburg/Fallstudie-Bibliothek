<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Home</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <style>
        button {
            margin-bottom: 10px; /* Add space below each button */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Library Management System</h1>
    <p>Click on the buttons below to visit different sites:</p>
    <button onclick="window.location.href='book_management.php'">Book Management</button><br>
    <button onclick="window.location.href='member_management.php'">Member Management</button><br>
    <button onclick="window.location.href='user_management.php'">User Mangagement</button><br>
    <button onclick="window.location.href='issue.php'">Issue Book</button><br>
    <button onclick="window.location.href='return.php'">Return Book</button><br>

    <br>
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>
