<?php
    include "../Code Backend/be_db_conn.php";

         // Check if 'book_id' parameter is set in the URL
        if (isset($_GET['book_id'])) {
             $book_id = $_GET['book_id'];

             // Check if the connection to the database is successful
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }

            // Sanitize the book_id to prevent SQL injection
            $book_id = $conn->real_escape_string($book_id);

            // Perform a query to fetch the book details from the database
            $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
            $result = $conn->query($sql);

            // Check if the query was successful and if there are any rows returned
            if ($result !== false && $result->num_rows > 0) {
            // Fetch the book details
            $book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
</head>

<body>
    <div class="background">
        <button class="button_back_to_booklist" onclick="window.location.href='booklist.php'">Back to Book List</button>
        <button class="button_add_book" onclick="window.location.href='book_add.php'">Add new Book</button>
        <div class="white-square" id="white-squareID">
            <div class="info-box">
                <h1>Book Details</h1>
                <p>Here you can see and manage the details of a specific book.</p>
                <button class="layer_sort" id="layer_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-layer-group" style="color: #656567;"></i>
                </button>
                <button class="vertical_sort" id="vertical_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-grip-vertical" style="color: #656567;"></i>
                </button>               
            </div>
            <div class="detail-content">
                <div class="form-container-bookdetails">
                            <form action="submit_form.php" method="post">
                                <div class="form-group-bookdetails">
                                    <label for="book_id">Book ID:</label>
                                    <input type="text" id="book_id" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>" readonly>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="author">Author:</label>
                                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="isbn">ISBN:</label>
                                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="genre">Genre:</label>
                                    <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="status">Status:</label>
                                    <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($book['status']); ?>" readonly>
                                </div> <!-- Confirmation message area -->
                            </form>
                            <?php
                        } else {
                            echo "<p>Book not found.</p>";
                        }

                        // Close the database connection
                        $conn->close();
                    } else {
                        echo "<p>No book ID specified.</p>";
                    }
                    ?>
                </div>
            </div>
        </div><!-- adding background -->
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
    <div> <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
        <button class="button_house"id="button_houseID"onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals"onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks"id="button_overduebooksID"onclick="window.location.href='overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
