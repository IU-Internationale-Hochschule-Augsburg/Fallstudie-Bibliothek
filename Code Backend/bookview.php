<?php
include "be_db_conn.php";

// Check if the ISBN is provided in the URL
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Fetch book details
    $query = "SELECT b.title, b.author, b.isbn, g.name AS genre, COUNT(bc.book_id) AS copies
              FROM book AS b
              INNER JOIN genre AS g ON b.genre_id = g.id
              LEFT JOIN book_copy AS bc ON b.book_id = bc.book_id
              WHERE b.isbn = '$isbn'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
    }

    // Fetch book copies
    $query = "SELECT * FROM book_copy WHERE book_id IN (SELECT book_id FROM book WHERE isbn = '$isbn')";
    $result = $conn->query($query);

    $copies = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $copies[] = $row;
        }
    }
} else {
    // If no ISBN is provided, redirect back to the booklist page
    header("Location: booklist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Copies</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Add border around the table */
        }
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Book Copies</h1>
    
    <table>
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Genre</th>
                <th>Copies</th>
                <th>Copy Number</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($copies as $copy) : ?>
            <tr>
                <td><?php echo $copy['copy_id']; ?></td>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['isbn']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['copies']; ?></td>
                <td><?php echo $copy['copy_number']; ?></td>
                <td><?php echo $copy['status']; ?></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <button onclick="goBack()">Back to Book List</button>
    
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
