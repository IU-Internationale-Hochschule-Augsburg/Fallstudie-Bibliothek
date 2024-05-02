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
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addBookManually($title, $author, $isbn, $genre) {
        $stmt = $this->conn->prepare("INSERT INTO books (title, author, isbn, genre) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $author, $isbn, $genre);
        $stmt->execute();
        $stmt->close();
        echo "Book added successfully!";
    }

    public function getAllBooks() {
        $result = $this->conn->query("SELECT * FROM books");
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["book_id"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["isbn"] . "</td>";
                echo "<td>" . $row["genre"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No books added yet.";
        }
    }
}

// MySQL server information
$servername = "localhost"; // Standard-Hostname für die lokale MySQL-Verbindung
$username = "root"; // Standardbenutzername für MySQL
$password = ""; // Standardpasswort für MySQL, leer lassen für keine Authentifizierung
$dbname = "library"; // Name der Datenbank, in der Ihre Bücher gespeichert werden

// Versuchen, eine Verbindung zur MySQL-Datenbank herzustellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen Sie die Verbindung auf Fehler
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookList = new BookList($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $isbn = $_POST["isbn"];
    $genre = $_POST["genre"];
    
    $bookList->addBookManually($title, $author, $isbn, $genre);
}

?>

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
    <?php $bookList->getAllBooks(); ?>
</body>
</html>

<?php
// Schließen Sie die MySQL-Verbindung am Ende
$conn->close();
?>
