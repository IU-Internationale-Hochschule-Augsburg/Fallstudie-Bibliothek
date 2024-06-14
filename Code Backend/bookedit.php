<?php
include "be_db_conn.php";

$book_id = "";
$title = "";
$author = "";
$isbn = "";
$genre = "";
$genres = [];  // Array to store genres
$status = "";

$error = "";
$success = "";

// Fetch all genres
$genre_query = "SELECT id, name FROM genre";
$genre_result = $conn->query($genre_query);
if ($genre_result) {
    while ($row = $genre_result->fetch_assoc()) {
        $genres[] = $row;
    }
} else {
    $error = "Failed to fetch genres: " . $conn->error;
}

// Check if the ISBN is provided in the URL
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Fetch book details
    $query = "SELECT books.book_id, books.title, books.author, books.isbn, genre.name AS genre, COUNT(book_copies.book_id) AS copies
              FROM books
              INNER JOIN genre ON books.genre_id = genre.id
              LEFT JOIN book_copies ON books.book_id = book_copies.book_id
              WHERE books.isbn = '$isbn'
              GROUP BY books.book_id";
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

    $update_query = "UPDATE books SET title = ?, author = ?, isbn = ?, genre_id = (SELECT id FROM genre WHERE name = ?) WHERE book_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $title, $author, $isbn, $genre, $book_id);

    if ($stmt->execute()) {
        $success = "Book details updated successfully.";
    } else {
        $error = "Failed to update the book details: " . $conn->error;
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
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>"><br>
        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>"><br>
        <label for="genre">Genre:</label><br>
        <select id="genre" name="genre">
            <?php foreach ($genres as $g): ?>
                <option value="<?php echo htmlspecialchars($g['name']); ?>" <?php echo ($g['name'] == $genre) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($g['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        <button type="submit">Update</button>
    </form>

    <?php if (!empty($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
</body>
</html>
