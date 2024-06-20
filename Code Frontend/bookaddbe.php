<?php
session_start();
include "../Code Backend/be_db_conn.php";

$title = "";
$author = "";
$isbn = "";
$genre = "";

$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];

    if (empty($title) || empty($author) || empty($isbn) || empty($genre)) {
        $messages[] = "All fields are required";
    } else {
        // Check if the book with the provided ISBN already exists
        $check_book_query = $conn->prepare("SELECT book_id, copies FROM books WHERE isbn = ?");
        $check_book_query->bind_param("s", $isbn);
        $check_book_query->execute();
        $result_check = $check_book_query->get_result();

        if ($result_check && $result_check->num_rows > 0) {
            // If the book exists, increment the copy number and update the copies count in the book table
            $row = $result_check->fetch_assoc();
            $book_id = $row['book_id'];
            $copies = $row['copies'];

            // Increment the number of copies in the book table
            $copies += 1;
            $update_book_query = $conn->prepare("UPDATE books SET copies = ? WHERE book_id = ?");
            $update_book_query->bind_param("ii", $copies, $book_id);
            $result_update_book = $update_book_query->execute();
            if (!$result_update_book) {
                $messages[] = "Failed to update the copies count in the book table: " . $conn->error;
            }

            // Add a new copy of the book to the book_copy table with the incremented copy number
            $insert_copy_query = $conn->prepare("INSERT INTO book_copies (book_id, copy_number, status) SELECT ?, MAX(copy_number) + 1, 'Available' FROM book_copies WHERE book_id = ?");
            $insert_copy_query->bind_param("ii", $book_id, $book_id);
            $result_copy = $insert_copy_query->execute();
            if ($result_copy) {
                $messages[] = "A new copy of " .  $title . " has been added successfully.";
            } else {
                $messages[] = "Failed to add a copy of the existing book to the book_copy table: " . $conn->error;
            }
        } else {
            // If the book doesn't exist, add the book to the book table and a copy to the book_copy table
            $insert_book_query = $conn->prepare("INSERT INTO books (title, author, isbn, genre_id, copies) VALUES (?, ?, ?, (SELECT id FROM genre WHERE name = ?), 1)");
            $insert_book_query->bind_param("ssss", $title, $author, $isbn, $genre);
            $result_book = $insert_book_query->execute();
            if ($result_book) {
                $book_id = $conn->insert_id; // Get the ID of the inserted book

                // Add a copy of the book to the book_copy table
                $insert_copy_query = $conn->prepare("INSERT INTO book_copies (book_id, copy_number, status) VALUES (?, 1, 'Available')");
                $insert_copy_query->bind_param("i", $book_id);
                $result_copy = $insert_copy_query->execute();
                if ($result_copy) {
                    $messages[] = "A new book " .  $title . " has been added successfully.";
                } else {
                    $messages[] = "Failed to add a copy of the book to the book_copy table: " . $conn->error;
                }
            } else {
                $messages[] = "Failed to add the book to the book table: " . $conn->error;
            }
        }
    }

    // Store messages in session and redirect back to bookadd.php
    $_SESSION['messages'] = $messages;
    header("Location: bookadd.php");
    exit();
}
?>
