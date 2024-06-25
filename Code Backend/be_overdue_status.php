<?php

include "be_db_conn.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$checkLoanDate = $conn->prepare("SELECT loan_id, borrow_date FROM loans WHERE status = 'open'");
$checkLoanDate->execute();
$result = $checkLoanDate->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $borrowDate = strtotime($row['borrow_date']);
        $currentDate = time();
        $daysPassed = floor(($currentDate - $borrowDate) / (60 * 60 * 24));

        if ($daysPassed > 14) {
            $updateLoanStatus = $conn->prepare("UPDATE loans SET status = 'Overdue' WHERE loan_id = ?");
            $updateLoanStatus->bind_param("i", $row['loan_id']);
            $updateLoanStatus->execute();
            $updateLoanStatus->close();
        }

       
    }
}


?>
