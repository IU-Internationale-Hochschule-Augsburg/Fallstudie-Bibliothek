<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <style>
        button {
            margin-bottom: 10px; /* Add space below each button */
        }
    </style>
</head>
<body>

    <h2>Issue Book</h2>
    <form action="issue_book.php" method="post">
        <label for="book_id">Book ID:</label><br>
        <input type="text" id="book_id" name="book_id"><br>
        <label for="member_id">Member ID:</label><br>
        <input type="text" id="member_id" name="member_id"><br><br>
        <input type="submit" value="Issue Book" name="issue_book">
    </form>

    <br>
    <button onclick="window.location.href='home.php'">Home</button>
    <br>
    <a href="logout.php" class="logout-button">Logout</a>

</body>
</html>

