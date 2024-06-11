<?php
session_start();
include "be_db_conn.php"; // Adjust the path if necessary

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST["member_id"];
    $book_ids = $_POST["book_id"]; // This is an array of book IDs
    $issue_date = date("Y-m-d");
    $return_date = date("Y-m-d", strtotime("+14 days"));
    $status = 'open'; // Set initial status to 'open';

    if (!empty($member_id) && !empty($book_ids)) {
        foreach ($book_ids as $book_id) {
            if (!empty($book_id)) {
                // Prepared statement to avoid SQL injection
                $stmt = $conn->prepare("INSERT INTO NEW_loans (member_id, book_id, borrow_date, return_date, status)
                                        VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $member_id, $book_id, $issue_date, $return_date, $status);
                if ($stmt->execute()) {
                    echo "New record created successfully for Book-ID: $book_id<br>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }
                $stmt->close();
            }
        }
    } else {
        echo "Please provide a member ID and at least one book ID.";
    }
}

$conn->close();
?>
