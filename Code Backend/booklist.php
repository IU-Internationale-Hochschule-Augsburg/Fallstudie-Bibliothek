<?php
include "be_db_conn.php";

$query = "SELECT book.title, book.author, book.isbn, genre.name AS genre, COUNT(book_copy.book_id) AS copies,
          SUM(CASE WHEN book_copy.status = 'Available' THEN 1 ELSE 0 END) AS available_copies,
          SUM(CASE WHEN book_copy.status = 'On Loan' THEN 1 ELSE 0 END) AS on_loan_copies
          FROM book
          INNER JOIN genre ON book.genre_id = genre.id
          LEFT JOIN book_copy ON book.book_id = book_copy.book_id
          GROUP BY book.book_id";

$result = $conn->query($query);

$books = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
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
    <button> <a href="bookadd.php">bookadd.php</a></button>
    <br>
    <br>
    <h1>Book List</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Genre</th>
                <th>Copies</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book) : ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['isbn']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['copies']; ?></td>
                <td>
                <?php
                    if ($book['available_copies'] == 0) {
                        echo "All Copies on Loan";
                    } 
                    if ($book['available_copies'] == 1) {
                        echo $book['available_copies'] . " Copy available ";
                    }
                    else {
                        echo $book['available_copies'] . " Copies available ";
                    }
                    ?>
                </td>
                <td>
                    <button> <a href="bookedit.php?isbn=<?php echo $book['isbn']; ?>">Edit</a></button>
                    <button> <a href="bookview.php?isbn=<?php echo $book['isbn']; ?>">View Copies</a></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>