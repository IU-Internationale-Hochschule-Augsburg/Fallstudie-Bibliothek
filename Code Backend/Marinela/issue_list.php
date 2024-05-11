<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Overview</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Add border around the table */
        }
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Issue List</h2>
    <?php
    include "db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform a query to fetch all books from the database
    $sql = "SELECT * FROM issues";
    $result = $conn->query($sql);

    // Check if the query was successful and if there are any rows returned
    if ($result !== false && $result->num_rows > 0) {
        // Display the table header and iterate through the fetched results
        echo "<table>";
        echo "<tr><th>Issue ID</th><th>Book ID</th><th>Member ID</th><th>Issue Date</th><th>Return Date</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["issue_id"] . "</td>";
            echo "<td>" . $row["book_id"] . "</td>";
            echo "<td>" . $row["member_id"] . "</td>";
            echo "<td>" . $row["issue_date"] . "</td>";
            echo "<td>" . $row["return_date"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // If no books are found, display a message
        echo "No books found.";
    }

    // Close the database connection
    $conn->close();
    ?>
    <br>
    <button onclick="window.location.href='home.php'">Home</button>
</body>
</html>
