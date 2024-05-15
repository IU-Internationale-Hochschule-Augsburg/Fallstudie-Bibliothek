<?php
session_start();
include "be_db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST["book_id"];
    
    // Check if the book has been issued
    $checkIssuedQuery = "SELECT * FROM issues WHERE book_id = ? AND status = 'open'";
    $stmt = $conn->prepare($checkIssuedQuery);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Book has been issued, proceed with return
        $updateIssueStatusQuery = "UPDATE issues SET status = 'Returned' WHERE book_id = ? AND status = 'open'";
        $stmt = $conn->prepare($updateIssueStatusQuery);
        $stmt->bind_param("i", $bookId);
        
        if ($stmt->execute()) {
            // Update book status to 'available'
            $updateBookStatusQuery = "UPDATE books SET status = 'Available' WHERE book_id = ?";
            $stmt = $conn->prepare($updateBookStatusQuery);
            $stmt->bind_param("i", $bookId);
            
            if ($stmt->execute()) {
                $_SESSION["message"] = "Book returned successfully!";
                header('Location: be_return_book.php'); // redirect back to your page
                exit();
            } else {
                $_SESSION["message"] = "Error updating book status: " . $stmt->error;
                header('Location: be_return_book.php'); // redirect back to your page
                exit();
            }
        } else {
            $_SESSION["message"] = "Error updating issue status: " . $stmt->error;
            header('Location: be_return_book.php'); // redirect back to your page
            exit();
        }
    } else {
        $_SESSION["message"] = "This book is not issued!";
        header('Location: be_return_book.php'); // redirect back to your page
        exit();
    }
}

$conn->close();
?>