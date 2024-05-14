<?php
session_start();
include "db_conn.php"; // Adjust the path if necessary

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST["member_id"];
    $bookId = $_POST["book_id"];
    $issueDate = date("Y-m-d");
    $returnDate = date("Y-m-d", strtotime("+14 days"));
    $status = 'open'; // Set initial status to 'open';
    
    // Check if the book is already issued
    $checkBookStatusQuery = $conn->prepare("SELECT status FROM books WHERE book_id = ?");
    $checkBookStatusQuery->bind_param("s", $bookId);
    $checkBookStatusQuery->execute();
    $result = $checkBookStatusQuery->get_result();
    $book = $result->fetch_assoc();

    if ($book['status'] == 'issued') {
        $_SESSION["message"] = "Book is already issued!";
    } else {
        // Create issue record
        $insertIssueQuery = $conn->prepare("INSERT INTO issues (member_id, book_id, issue_date, return_date, status) 
                                            VALUES (?, ?, ?, ?, ?)");
        $insertIssueQuery->bind_param("sssss", $memberId, $bookId, $issueDate, $returnDate, $status);

        if ($insertIssueQuery->execute() === TRUE) {
            // Update book status to 'issued'
            $updateBookStatusQuery = $conn->prepare("UPDATE books SET status = 'Issued' WHERE book_id = ?");
            $updateBookStatusQuery->bind_param("s", $bookId);
            $updateBookStatusQuery->execute();
            
            $_SESSION["message"] = "Book issued successfully!"; // Save the message to the variable
        } else {
            $_SESSION["message"] = "Error issuing book: " . $conn->error; // Save the error message to the variable
        }
    }

    $conn->close();
    header("Location: issue.php"); // Redirect back to the issue form
    exit();
}
?>
