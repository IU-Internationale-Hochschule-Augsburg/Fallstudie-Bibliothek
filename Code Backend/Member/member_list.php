<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member List</title>
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
    <h2>Member List</h2>
    <?php
    include "db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform a query to fetch all books from the database
    $sql = "SELECT * FROM members";
    $result = $conn->query($sql);

    // Check if the query was successful and if there are any rows returned
    if ($result !== false && $result->num_rows > 0) {
        // Display the table header and iterate through the fetched results
        echo "<table>";
        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["member_id"] . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // If no members are found, display a message
        echo "No members found.";
    }

    // Close the database connection
    $conn->close();
    ?>
    <br>
    <button onclick="window.location.href='home.php'">Home</button>
</body>
</html>
