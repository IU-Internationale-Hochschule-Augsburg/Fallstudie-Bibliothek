/* Work in progress */


<?php
include "../Code Backend/be_db_conn.php";

$book_id = $_POST['book_id'];
$title = $_POST['title'];
$author = $_POST['author'];
$isbn = $_POST['isbn'];
$genre = $_POST['genre'];
$status = $_POST['status'];

$sql = "UPDATE books SET title = ?, author = ?, isbn = ?, genre = ?, status = ? WHERE book_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisi", $title, $author, $isbn, $genre, $status, $book_id);

if ($stmt->execute()) {
    echo "Book details updated successfully";
    header("Location: test_book_edit.php?id=$book_id"); // Redirect back to the book detail page
} else {
    echo "Error updating book details: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

