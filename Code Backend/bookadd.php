<?php
include "be_db_conn.php";

$title = "";
$author = "";
$isbn = "";
$genre = "";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];

    if (empty($title) || empty($author) || empty($isbn) || empty($genre)) {
        $error = "All fields are required";
    } else {
        // Check if the book with the provided ISBN already exists
        $check_book_query = "SELECT `book_id`, `copies` FROM `book` WHERE `isbn` = '$isbn'";
        $result_check = $conn->query($check_book_query);
        if ($result_check && $result_check->num_rows > 0) {
            // If the book exists, increment the copy number and update the copies count in the book table
            $row = $result_check->fetch_assoc();
            $book_id = $row['book_id'];
            $copies = $row['copies'];

            // Increment the number of copies in the book table
            $copies += 1;
            $update_book_query = "UPDATE `book` SET `copies` = $copies WHERE `book_id` = $book_id";
            $result_update_book = $conn->query($update_book_query);
            if (!$result_update_book) {
                $error = "Failed to update the copies count in the book table: " . $conn->error;
            }

            // Add a new copy of the book to the book_copy table with the incremented copy number
            $insert_copy_query = "INSERT INTO `book_copy` (`book_id`, `copy_number`, `status`)
                                  SELECT '$book_id', MAX(`copy_number`) + 1, 'Available' FROM `book_copy` WHERE `book_id` = '$book_id'";
            $result_copy = $conn->query($insert_copy_query);
            if ($result_copy) {
                $success = "A new copy of the existing book has been added successfully.";
            } else {
                $error = "Failed to add a copy of the existing book to the book_copy table: " . $conn->error;
            }
        } else {
            // If the book doesn't exist, add the book to the book table and a copy to the book_copy table
            $insert_book_query = "INSERT INTO `book` (`title`, `author`, `isbn`, `genre_id`, `copies`) 
                                  VALUES ('$title', '$author', '$isbn', (SELECT `id` FROM `genre` WHERE `name` = '$genre'), 1)";
            $result_book = $conn->query($insert_book_query);
            if ($result_book) {
                $book_id = $conn->insert_id; // Get the ID of the inserted book

                // Add a copy of the book to the book_copy table
                $insert_copy_query = "INSERT INTO `book_copy` (`book_id`, `copy_number`, `status`)
                                      VALUES ('$book_id', 1, 'Available')";
                $result_copy = $conn->query($insert_copy_query);
                if ($result_copy) {
                    $success = "A new book has been added successfully.";
                } else {
                    $error = "Failed to add a copy of the book to the book_copy table: " . $conn->error;
                }
            } else {
                $error = "Failed to add the book to the book table: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn">
        <br>

        <label for="title">Title</label>
        <input type="text" id="title" name="title">
        <br>

        <label for="author">Author</label>
        <input type="text" id="author" name="author">
        <br>

        <label for="genre">Genre:</label>
        <select id="genre" name="genre">
            <option value="Fantasy">Fantasy</option>
            <option value="History">History</option>
            <option value="Romance">Romance</option>
            <option value="Science Fiction">Science Fiction</option>
            <option value="Science">Science</option>
            <option value="Sport">Sport</option>
        </select>
        <br>

        <button type="submit" name="submit">Submit</button>
    </form>

    <?php if (!empty($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>

