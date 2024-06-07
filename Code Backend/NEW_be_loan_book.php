<?php
session_start();
include "be_db_conn.php"; // Adjust the path if necessary

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST["member_id"];
    $bookId = $_POST["book_id"]; // This is an array of book IDs
    $issueDate = date("Y-m-d");
    $returnDate = date("Y-m-d", strtotime("+14 days"));
    $status = 'open'; // Set initial status to 'open';

}

$messages = [];
foreach($bookId as $bookId) {
    // Check if the book is already loaned
    $checkBookStatusQuery = $conn->prepare("SELECT status FROM books WHERE book_id = ?");
    $checkBookStatusQuery->bind_param("s", $bookId);
    $checkBookStatusQuery->execute();
    $result = $checkBookStatusQuery->get_result();
    $book = $result->fetch_assoc();

    if($book['status'] == 'On loan') {
        $messages[] = "Book ID $bookId is already loaned";
    } else {
        //Create loan record
        $insertLoanQuery = $conn->prepare("INSERT INTO NEW_loans (book_id, member_id, borrow_date, return_date, status)
                                            VALUES (?, ?, ?, ?, ?)");
        $insertLoanQuery->bind_param("sssss", $bookId, $memberId, $issueDate, $returnDate, $status);                    

        if ($insertLoanQuery->execute() === TRUE) {
            // Update book status to 'loaned'
            $updateBookStatusQuery = $conn->prepare("UPDATE books SET status = 'On loan' WHERE book_id = ?");
            $updateBookStatusQuery->bind_param("s", $bookId);
            $updateBookStatusQuery->execute();
            
            $messages[] = "Book ID $bookId loaned successfully!";
        } else {
            $messages[] = "Error loaning Book ID $bookId: " . $conn->error;
        }
    }
    $_SESSION["message"] = implode("<br>", $messages);
}   

$conn->close();

header("Location: NEW_be_loan.php");
exit();

?>