<?php
include "be_db_conn.php";

$book_id = "";
$title = "";
$author = "";
$isbn = "";
$genre = "";
$status = "";

$error = "";
$success = "";

// Check if the ISBN is provided in the URL
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Fetch book details
    $query = "SELECT b.book_id, b.title, b.author, b.isbn, g.name AS genre, COUNT(bc.book_id) AS copies
              FROM book AS b
              INNER JOIN genre AS g ON b.genre_id = g.id
              LEFT JOIN book_copy AS bc ON b.book_id = bc.book_id
              WHERE b.isbn = '$isbn'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $book_id = $book['book_id'];
        $title = $book['title'];
        $author = $book['author'];
        $isbn = $book['isbn'];
        $genre = $book['genre'];
        $copies = $book['copies'];
    } else {
        // If no book is found, redirect back to the booklist page
        header("Location: booklist.php");
        exit();
    }
} else {
    // If no ISBN is provided, redirect back to the booklist page
    header("Location: booklist.php");
    exit();
}

// Update book details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];

    $update_query = "UPDATE book SET title = '$title', author = '$author', isbn = '$isbn', genre_id = (SELECT id FROM genre WHERE name = '$genre') WHERE book_id = '$book_id'";
    $result = $conn->query($update_query);

    if ($result) {
        // Redirect to the booklist page after successful update
        $success = "Book details updated successfully.";
    } else {
        $error = "Failed to update the book details " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>
    <form method="post">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" value="<?php echo $author; ?>"><br>
        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn" value="<?php echo $isbn; ?>"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>"><br><br>
        <button type="submit">Update</button>
    </form>

    <?php if (!empty($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
</body>
</html>
