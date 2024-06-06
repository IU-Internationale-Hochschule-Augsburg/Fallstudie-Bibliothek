<?php
    include "../Code Backend/be_db_conn.php";
    if(isset($_GET['book_id'])){
        $book_id = $_GET['book_id'];
        $stmt = $conn->prepare("DELETE FROM `books` WHERE book_id = ?");
        $stmt->bind_param("i", $book_id);
        if ($stmt->execute() === TRUE) {
            header('location:fe_booklist.php');
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "No book ID provided.";
    }
    $conn->close();
?>