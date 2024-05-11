<?php
include "db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $updateReturnDateQuery = "UPDATE issues SET status = 'closed', return_date = NOW() WHERE book_id = ? AND status = 'open'";
        
        $stmt = $conn->prepare($updateReturnDateQuery);
        $stmt->bind_param("i", $bookId);
        
        if ($stmt->execute()) {
            // Update book status to 'available'
            $updateBookStatusQuery = "UPDATE books SET status = 'available' WHERE book_id = ?";
            
            $stmt = $conn->prepare($updateBookStatusQuery);
            $stmt->bind_param("i", $bookId);
            
            if ($stmt->execute()) {
                echo "Book returned successfully!";
            } else {
                echo "Error updating book status: " . $conn->error;
            }
        } else {
            echo "Error updating return date: " . $conn->error;
        }
    } else {
        // Book has not been issued, cannot return
        echo "Book has not been issued.";
    }
}

$conn->close();
?>
