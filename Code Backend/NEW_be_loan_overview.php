<!DOCTYPE html>
<html lang = "en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEW Loan Overview</title>
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
    <?php
include "be_db_conn.php";

// Check if the connection to the database is successful
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

// Perform a query to fetch all books from the database
$sql = "
    SELECT NEW_loans.loan_id, books.title, books.book_id, members.first_name, members.last_name, NEW_loans.borrow_date, NEW_loans.return_date, NEW_loans.status 
    FROM NEW_loans 
    INNER JOIN books ON NEW_loans.book_id = books.book_id 
    INNER JOIN members ON NEW_loans.member_id = members.member_id 
    ORDER BY NEW_loans.loan_id DESC";
$result = $conn->query($sql);

// Check if the query was successful and if there are any rows returned
if ($result !== false && $result->num_rows > 0) {
    // Display the table header and iterate through the fetched results
    echo "<table>";
    echo "<tr><th>Loan ID</th><th>Book Title</th><th>Book ID</th><th>Member Name</th><th>Borrow Date</th><th>Return Date</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["loan_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["book_id"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["borrow_date"] . "</td>";
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