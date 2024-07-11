<?php
//This script is included in ../Code Frontend/overduebooks.php

include "be_db_conn.php"; // Connection to Database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$status = "Overdue";


// Perform a query to fetch all overdue loans from the database
$overdueLoans = $conn->prepare("SELECT * FROM loans WHERE status = ?");
$overdueLoans->bind_param("s", $status );
$overdueLoans->execute();
$result = $overdueLoans->get_result();

// Check if there are any overdue-loans in the database
if ($result->num_rows > 0) {

    // Display all overdue-loans in a table
    echo "<table id='table_booklist'>";
    echo "<tr><th>Loan-ID</th><th>Book-ID</th><th>Member-ID</th><th>Borrow-Date</th><th>Return-Date</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["loan_id"] . "</td>";
        echo "<td>" . $row["book_id"] . "</td>";
        echo "<td>" . $row["member_id"] . "</td>";
        echo "<td>" . $row["borrow_date"] . "</td>";
        echo "<td>" . $row["return_date"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No overdue loans found";
}
?>