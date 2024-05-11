<?php
include "db_conn.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST["book_id"];
    
    // Check if the book has been issued
    $checkIssuedQuery = "SELECT * FROM issues WHERE book_id = $bookId AND return_date IS NULL";
    $issuedResult = $conn->query($checkIssuedQuery);
    
    if ($issuedResult->num_rows > 0) {
        // Book has been issued, proceed with return
        $updateReturnDateQuery = "UPDATE issues SET return_date = NOW() WHERE book_id = $bookId AND return_date > NOW()";
        $conn->query($updateReturnDateQuery);
        
        $updateBookStatusQuery = "UPDATE books SET status = 'available' WHERE book_id = $bookId";
        $conn->query($updateBookStatusQuery);
        
        $message = "Book returned successfully!";
    } else {
        // Book has not been issued, cannot return
        $message = "Book has not been issued.";
    }
}

$conn->close();
?>