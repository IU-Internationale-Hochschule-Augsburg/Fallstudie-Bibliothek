<?php
include "db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST["member_id"];
    $bookId = $_POST["book_id"];
    $issueDate = date("Y-m-d");
    $returnDate = date("Y-m-d", strtotime("+14 days"));
    $status = 'open'; // Set initial status to 'open'
    
    // Create issue record
    $insertIssueQuery = "INSERT INTO issues (member_id, book_id, issue_date, return_date, status) 
                         VALUES ('$memberId', '$bookId', '$issueDate', '$returnDate', '$status')";
    if ($conn->query($insertIssueQuery) === TRUE) {
        // Update book status to 'issued'
        $updateBookStatusQuery = "UPDATE books SET status = 'issued' WHERE book_id = '$bookId'";
        $conn->query($updateBookStatusQuery);
        
        echo "Book issued successfully!";
    } else {
        echo "Error issuing book: " . $conn->error;
    }
}

$conn->close();
?>
