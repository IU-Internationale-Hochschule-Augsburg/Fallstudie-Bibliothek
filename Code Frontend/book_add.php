<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
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
                <button class="layer_sort" id="layer_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-layer-group" style="color: #656567;"></i>
                </button>
                <button class="vertical_sort" id="vertical_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-grip-vertical" style="color: #656567;"></i>
                </button>
            </div> <!-- adding background -->
            <div class="form-container-addbook">
                <?php
                session_start();
                if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
                    echo '<div class="messages">';
                    foreach ($_SESSION['messages'] as $message) {
                        echo '<p>' . htmlspecialchars($message) . '</p>';
                    }
                    echo '</div>';
                    unset($_SESSION['messages']); // Clear messages after displaying
                }
                ?>

                <form method="post" action="">
                    <div class="form-group-addbook">
                        <label for="isbn">Enter ISBN:</label>
                        <input type="text" id="isbn" name="isbn" required>
                    </div>
                    <div class="form-group-addbook">
                        <button type="submit" name="search">Search</button>
                    </div>
                </form>

                <?php
                // Enable error reporting
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                    $isbn = htmlspecialchars($_POST['isbn']);
                    search_book_by_isbn($isbn);
                }

                function search_book_by_isbn($isbn) {
                    $url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . urlencode($isbn) . "&format=json&jscmd=data";

                    // Using cURL for better error handling
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'cURL error: ' . curl_error($ch);
                    }
                    curl_close($ch);

                    if ($response !== FALSE) {
                        $books = json_decode($response, true);
                        $book_key = "ISBN:$isbn";
                        if ($books && isset($books[$book_key])) {
                            $book = $books[$book_key];
                            $title = htmlspecialchars($book['title']);
                            $authors = array_map(function($author) { return $author['name']; }, $book['authors']);
                            $authors_str = implode(", ", $authors);
                            $publish_date = $book['publish_date'] ?? 'N/A';

                            // Retrieve cover image
                            $cover_url = $book['cover']['medium'] ?? null;

                            echo "<h2>Book Details</h2>";

                            // Display cover image if available
                            if ($cover_url) {
                                echo "<img src='$cover_url' alt='Cover Image'><br>";
                            } else {
                                echo "No cover image available.<br>";
                            }

                            // Form To add Book
                            echo '<form action="book_add_be.php" method="post">';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="title">Title:</label>';
                            echo '<input type="text" id="title" name="title" value="' . $title . '">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="author">Author:</label>';
                            echo '<input type="text" id="author" name="author" value="' . $authors_str . '">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="isbn">ISBN:</label>';
                            echo '<input type="text" id="isbn" name="isbn" value="' . $isbn . '">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="genre">Genre:</label>';
                            echo '<select id="genre" name="genre">';
                            echo '<option value="Fantasy">Fantasy</option>';
                            echo '<option value="History">History</option>';
                            echo '<option value="Romance">Romance</option>';
                            echo '<option value="Science Fiction">Science Fiction</option>';
                            echo '<option value="Science">Science</option>';
                            echo '<option value="Sport">Sport</option>';
                            echo '<option value="Fiction">Fiction</option>';
                            echo '</select>';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<button type="submit" name="submit_book">Submit</button>';
                            echo '</div>';
                            echo '</form>';
                        } else {
                            echo "No book found for ISBN: $isbn. Please recheck the ISBN or enter the book's data manually.";
                            echo '<br>';

                            echo '<form action="bookaddbe.php" method="post">';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="title">Title:</label>';
                            echo '<input type="text" id="title" name="title">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="author">Author:</label>';
                            echo '<input type="text" id="author" name="author">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="isbn">ISBN:</label>';
                            echo '<input type="text" id="isbn" name="isbn" value="' . $isbn . '">';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<label for="genre">Genre:</label>';
                            echo '<select id="genre" name="genre">';
                            echo '<option value="Fantasy">Fantasy</option>';
                            echo '<option value="History">History</option>';
                            echo '<option value="Romance">Romance</option>';
                            echo '<option value="Science Fiction">Science Fiction</option>';
                            echo '<option value="Science">Science</option>';
                            echo '<option value="Sport">Sport</option>';
                            echo '<option value="Fiction">Fiction</option>';
                            echo '</select>';
                            echo '</div>';

                            echo '<div class="form-group-addbook">';
                            echo '<button type="submit" name="submit_book">Submit</button>';
                            echo '</div>';
                            echo '</form>';
                        }
                    } else {
                        echo "Error retrieving data.";
                    }
                }
                ?>
            </div>
        </div> <!-- adding background -->      
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house" id="button_houseID" onclick="window.location.href='fe_dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks" id="button_overduebooksID" onclick="window.location.href='fe_overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_settings">
                <i class="fa-solid fa-gear" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks" onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
