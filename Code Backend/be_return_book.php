<?php
//This script is included in ../Code Frontend/loan_book.php

session_start();
include "be_db_conn.php"; // Connection to Database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST["member_id"]; // Member ID gets fetched from the form in ../Code Frontend/return_book.php
    $book_ids = $_POST["book_id"]; // The book IDs get fetched from the form in ../Code Frontend/return_book.php
    
    if (!empty($member_id) && !empty($book_ids)) {
        $messages = [];
        foreach ($book_ids as $book_id) {
        
            if (!empty($book_id)) {

                // Check if the book has been loaned
                $checkStatusQuery = $conn->prepare("SELECT status FROM book_copies WHERE copy_id = ? AND status = 'On Loan'");
                $checkStatusQuery->bind_param("i", $book_id);
                $checkStatusQuery->execute();
                $result = $checkStatusQuery->get_result();

                if ($result->num_rows > 0) {
                
                    // Check which member has loaned the book
                    $checkMemberId = $conn->prepare("SELECT member_id FROM loans WHERE book_id = ? AND (status = 'open' OR status = 'Overdue')");
                    $checkMemberId->bind_param("i", $book_id);
                    $checkMemberId->execute();
                    $result = $checkMemberId->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $loaned_member_id = $row['member_id'];

                        // Check if the returning member is the same as the member who loaned the book
                        if ($loaned_member_id == $member_id) {
                            $updateReturnDate = "UPDATE loans SET return_date = CURRENT_DATE WHERE book_id = ? AND (status = 'open' OR status = 'Overdue')";
                            $stmt = $conn->prepare($updateReturnDate);
                            $stmt->bind_param("i", $book_id);
                            $stmt->execute();
                        
                            // Update loan status to 'Returned'
                            $updateIssueStatusQuery = "UPDATE loans SET status = 'Returned' WHERE book_id = ? AND (status = 'open' OR status = 'Overdue')";
                            $stmt = $conn->prepare($updateIssueStatusQuery);
                            $stmt->bind_param("i", $book_id);
                            $stmt->execute();
                        
                            if ($stmt->execute()) {

                                // Update book status to 'available'
                                $updateBookStatusQuery = "UPDATE book_copies SET status = 'Available' WHERE copy_id = ?";
                                $stmt = $conn->prepare($updateBookStatusQuery);
                                $stmt->bind_param("i", $book_id);
                        
                                if ($stmt->execute()) {
                                    $messages[] = "Book $book_id returned successfully!";
                                } else {
                                    $messages[] = "Error updating book-status for book $book_id";
                                }
                            } else {
                                $messages[] = "Error updating loan-status for book $book_id";
                            }
                        } else {
                            $messages[] = "The Book $book_id is not loaned by member $member_id";
                        }
                    } else {
                        $messages[] = "No active loan found for Book $book_id";
                    }
                        
                } else {
                    $messages[] = "The Book $book_id is not currently loaned";
                }
            }
        }
        $_SESSION["message"] = implode("<br>", $messages);
        header('Location: ../Code Frontend/return_book.php'); // redirect to ../Code Frontend/return_book.php
        exit();
    } else {
        $_SESSION["message"] = "Member ID or Book IDs are empty.";
        header('Location: ../Code Frontend/return_book.php'); // redirect to ../Code Frontend/return_book.php
        exit();
    }
}

$conn->close();
?>
