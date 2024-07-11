<?php
//This script is included in ../Code Frontend/loan_book.php

session_start();
include "be_db_conn.php"; // Connection to Database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST["member_id"]; // Member ID gets fetched from the form in ../Code Frontend/loan_book.php
    $book_ids = $_POST["book_id"]; // Book ID gets fetched from the form in ../Code Frontend/loan_book.php
    $issue_date = date("Y-m-d"); // Set issue date to current date
    $status = 'open'; // Set initial status to 'open';

    if (!empty($member_id) && !empty($book_ids)) {
        $messages = [];

        foreach ($book_ids as $book_id) {
            if (!empty($book_id)) {

                // Check if the book exists in the database
                $checkBookExistenceQuery = $conn->prepare("SELECT copy_id FROM book_copies WHERE copy_id = ?");
                $checkBookExistenceQuery->bind_param("s", $book_id);
                $checkBookExistenceQuery->execute();
                $result = $checkBookExistenceQuery->get_result();
                
                if ($result->num_rows > 0) {

                    //Check if the book is already loaned
                    $checkBookStatusQuery = $conn->prepare("SELECT status FROM book_copies WHERE copy_id = ?");
                    $checkBookStatusQuery->bind_param("s", $book_id);
                    $checkBookStatusQuery->execute();
                    $result = $checkBookStatusQuery->get_result();
                    $book = $result->fetch_assoc();
                    
                    if ($book['status'] == 'On Loan') {
                        $messages[] = "Book ID $book_id is already loaned!";
                    } else {
                        // Create a new loan
                        $insertLoanQuery = $conn->prepare("INSERT INTO loans (member_id, book_id, borrow_date, return_date, status) VALUES (?, ?, ?, ?, ?)");
                        $insertLoanQuery->bind_param("sssss", $member_id, $book_id, $issue_date, $return_date, $status);

                        if ($insertLoanQuery->execute() === TRUE) {
                            
                            // Update book status to 'On loan'
                            $updateBookStatusQuery = $conn->prepare("UPDATE book_copies SET status = 'On loan' WHERE copy_id = ?");
                            $updateBookStatusQuery->bind_param("s", $book_id);
                            $updateBookStatusQuery->execute();

                            $messages[] = "Book ID $book_id loaned successfully!";
                        } else {
                            $messages[] = "Error loaning Book ID $book_id: " . $conn->error;
                        }
                    }
                } else {
                    $messages[] = "Book ID $book_id does not exist in the database!";
                }
            }
        }
        $_SESSION["message"] = implode("<br>", $messages);
    } else {
        $_SESSION["message"] = "Please provide a member ID and at least one book ID.";
    }
}

$conn->close();

header("Location: ../Code Frontend/loan_book.php");
exit();
?>
