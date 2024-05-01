<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Add a New Book</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author"><br>
        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre"><br><br>
        <input type="submit" value="Submit">
    </form>

    <h2>Book List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Genre</th>
        </tr>
        <?php
        $bookList = new BookList();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $author = $_POST["author"];
            $isbn = $_POST["isbn"];
            $genre = $_POST["genre"];
            
            $bookList->addBookManually($title, $author, $isbn, $genre);
        }

        $bookList->displayBookTable();
        ?>
    </table>
</body>
</html>

<?php

class Book {
    public $id;
    public $title;
    public $author;
    public $isbn;
    public $genre;

    public function __construct($id, $title, $author, $isbn, $genre) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->genre = $genre;
    }
}

class BookList {
    private $books = [];
    private $nextId = 1; // Starting ID
    private $filename = 'books.txt';

    public function __construct() {
        if (file_exists($this->filename)) {
            $this->loadFromFile();
        }
    }

    public function addBookManually($title, $author, $isbn, $genre) {
        $id = $this->nextId++;
        $book = new Book($id, $title, $author, $isbn, $genre);
        $this->books[] = $book;
        $this->saveToFile();
    }

    public function displayBookTable() {
        if (empty($this->books)) {
            echo "<tr><td colspan='5'>No books added yet.</td></tr>";
        } else {
            foreach ($this->books as $book) {
                echo "<tr>";
                echo "<td>" . $book->id . "</td>";
                echo "<td>" . $book->title . "</td>";
                echo "<td>" . $book->author . "</td>";
                echo "<td>" . $book->isbn . "</td>";
                echo "<td>" . $book->genre . "</td>";
                echo "</tr>";
            }
        }
    }

    private function saveToFile() {
        file_put_contents($this->filename, serialize($this->books));
    }

    private function loadFromFile() {
        $data = file_get_contents($this->filename);
        $this->books = unserialize($data);
    }
}
?>
