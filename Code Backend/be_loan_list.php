<?php
//This script is included in ../Code Frontend/loans.php

include "be_db_conn.php"; // Connection to Database

if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

// Perform a query to fetch all necessary data from the database
$sql = "
    SELECT loans.loan_id, books.title, book_copies.copy_id, members.member_id, loans.borrow_date, loans.return_date, loans.status 
    FROM loans 
    INNER JOIN book_copies ON loans.book_id = book_copies.copy_id
    INNER JOIN books ON book_copies.book_id = books.book_id
    INNER JOIN members ON loans.member_id = members.member_id
    ORDER BY loans.loan_id DESC";
$result = $conn->query($sql);

// Check if there are any loans in the database
if ($result->num_rows > 0) {

    // Display all loans in a table
    echo "<table id='table_booklist'>";
    echo "<tr><th>Loan-ID</th><th>Book-Title</th><th>Book-ID</th><th>Member-ID</th><th>Borrow-Date</th><th>Return-Date</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["loan_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["copy_id"] . "</td>";
        echo "<td>" . $row["member_id"] . "</td>";
        echo "<td>" . $row["borrow_date"] . "</td>";
        echo "<td>" . $row["return_date"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No loans found.";
}
?>
</body>
</html>