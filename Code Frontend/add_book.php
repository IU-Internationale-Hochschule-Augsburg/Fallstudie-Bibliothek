<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <style>
        
 
        table {
            border-collapse: collapse;
            width: 100%; /* Make the table take the full width of its parent */
            border: 1px solid #000; /* Add border around the table */
            max-width: 100%; /* Ensure the table does not exceed its parent's width */
            box-sizing: border-box; /* Include padding and border in element's total width */
        }
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }
        form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 500px; /* Adjust as needed */
    margin: auto;
    padding: 20px;
    border: 2px solid #000;
    border-radius: 5px; /* Rounded corners */
    font-weight: bold;
 
}
 
form input, form select, form textarea {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #000;
    border-radius: 5px; /* Rounded corners */
}
 
form button {
    padding: 10px;
    border: none;
    border-radius: 5px; /* Rounded corners */
    background-color: #000;
    color: #fff;
    cursor: pointer;
}
h2 {
    text-align: center;
}


       
    </style>
</head>
<body>
    <div class="background">
    <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Back to Booklist</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
            
    <div class="white-square"> 
    <div class="info-box">
                    <h1>Add Book</h1>
                    <p>Here you can add new books to the catalog</p>
                </div> <!-- adding background -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author"><br>
        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre"><br><br>
        <input type="submit" value="Add Book">
    </form>
   
        </div>
    </div> <!-- adding background -->      
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_profile">Mitarbeiter_1</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.html'"></button>
            <button class="button_equals" onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.html'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.html'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php''">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>
 

// Backend Code

<?php
  include "../Code Backend/be_db_conn.php";
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
            echo "<table class='book-table'>";
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
 
$bookList = new BookList($conn);
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $isbn = $_POST["isbn"];
    $genre = $_POST["genre"];
   
    $bookList->addBookManually($title, $author, $isbn, $genre);
}
 
?>
