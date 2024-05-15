<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Overview</title>
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
    <h2>Loan List</h2>
    <br>
    <button onclick="window.location.href='be_home.php'">Home</button>
    <br>
    <br>
    <?php
include "be_db_conn.php";

// Check if the connection to the database is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform a query to fetch all books from the database
$sql = "
    SELECT issues.issue_id, books.title, members.first_name, members.last_name, issues.issue_date, issues.return_date, issues.status 
    FROM issues 
    INNER JOIN books ON issues.book_id = books.book_id 
    INNER JOIN members ON issues.member_id = members.member_id 
    ORDER BY issues.issue_id DESC";
$result = $conn->query($sql);

// Check if the query was successful and if there are any rows returned
if ($result !== false && $result->num_rows > 0) {
    // Display the table header and iterate through the fetched results
    echo "<table>";
    echo "<tr><th>Issue ID</th><th>Book Title</th><th>Member Name</th><th>Issue Date</th><th>Return Date</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["issue_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["issue_date"] . "</td>";
        echo "<td>" . $row["return_date"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No issues found.";
}
?>
</body>
</html>
