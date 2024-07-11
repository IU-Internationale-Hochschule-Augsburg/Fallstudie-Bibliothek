<?php
//This script is included in ../Code Frontend/loans.php

include "be_db_conn.php"; // Connection to Database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform a query to fetch loan_id and borrow-date of all open loans from the database
$checkLoanDate = $conn->prepare("SELECT loan_id, borrow_date FROM loans WHERE status = 'open'");
$checkLoanDate->execute();
$result = $checkLoanDate->get_result();

if ($result->num_rows > 0) {
    // Check if the loan is overdue
    while ($row = $result->fetch_assoc()) {
        $borrowDate = strtotime($row['borrow_date']);
        $currentDate = time();
        $daysPassed = floor(($currentDate - $borrowDate) / (60 * 60 * 24)); // Calcualte the days passed since the loan was created Source: Chat GPT (Prompt: Calculate the time between the borrow date and the current date.)

        // If the loan is overdue, update the status to 'Overdue'
        if ($daysPassed > 14) {
            $updateLoanStatus = $conn->prepare("UPDATE loans SET status = 'Overdue' WHERE loan_id = ?");
            $updateLoanStatus->bind_param("i", $row['loan_id']);
            $updateLoanStatus->execute();
            $updateLoanStatus->close();
        }

       
    }
}


?>
