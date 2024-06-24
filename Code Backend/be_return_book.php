<?php
session_start();
include "be_db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST["member_id"];
    $book_ids = $_POST["book_id"]; // This is an array of book IDs
    
    if (!empty($member_id) && !empty($book_ids)) {
        $messages = [];
        foreach ($book_ids as $book_id) {
        
            if (!empty($book_id)) {

                // Check if the book has been issued
                $checkStatusQuery = $conn->prepare("SELECT status FROM book_copies WHERE copy_id = ? AND status = 'On Loan'");
                $checkStatusQuery->bind_param("i", $book_id);
                $checkStatusQuery->execute();
                $result = $checkStatusQuery->get_result();
    
                if ($result->num_rows > 0) {
                    // Book has been issued, proceed with return
                    $updateIssueStatusQuery = "UPDATE loans SET status = 'Returned' WHERE book_id = ? AND status = 'open'";
                    $stmt = $conn->prepare($updateIssueStatusQuery);
                    $stmt->bind_param("i", $book_id);

                    $updateReturnDate = "UPDATE loans SET return_date = CURRENT_DATE WHERE book_id = ? AND status = 'open'";
                    $stmt = $conn->prepare($updateReturnDate);
                    $stmt->bind_param("i", $book_id);
        
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
                    $messages[] = "The Book $book_id is not currently loaned";
                }
            }
        }
        $_SESSION["message"] = implode("<br>", $messages);
        header('Location: ../Code Frontend/fe_return_book.php'); // redirect back to your page
        exit();
    } else {
        $_SESSION["message"] = "Member ID or Book IDs are empty.";
        header('Location: ../Code Frontend/fe_return_book.php'); // redirect back to your page
        exit();
    }
}



$conn->close();
?>