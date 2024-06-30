<?php
// Include the database connection file
include "../Code Backend/be_db_conn.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form input
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $genre = $conn->real_escape_string($_POST['genre']);

    // Update the book details in the database
    $sql = "UPDATE books SET 
                title='$title', 
                author='$author', 
                isbn='$isbn', 
                genre='$genre'
            WHERE book_id='$book_id'";

if ($conn->query($sql) === TRUE) {
    $confirmation_message = "Book updated successfully";
} else {
    $confirmation_message = "Error updating record: " . $conn->error;
}

header("Location: book_details.php?book_id=$book_id&message=$confirmation_message");
exit();

    // Close the database connection
    $conn->close();
} else {
    // If the form wasn't submitted, redirect back to the book list
    header("Location: booklist.php");
    exit();
}
?>

