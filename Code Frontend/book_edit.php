<?php
    include "../Code Backend/be_db_conn.php";

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
                        WHERE books.isbn = ?
                        GROUP BY books.book_id";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $isbn);
                $stmt->execute();
                $result = $stmt->get_result();

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
                    header("Location: fe_booklist.php");
                    exit();
                }
            } else {
                // If no ISBN is provided, redirect back to the booklist page
                header("Location: fe_booklist.php");
                exit();
            }

            // Update book details
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $book_id = $_POST['book_id'];
                $title = $_POST['title'];
                $author = $_POST['author'];
                $isbn = $_POST['isbn'];
                $genre = $_POST['genre'];

                // Get genre ID from genre name
                $genre_id_query = "SELECT id FROM genre WHERE name = ?";
                $genre_stmt = $conn->prepare($genre_id_query);
                $genre_stmt->bind_param("s", $genre);
                $genre_stmt->execute();
                $genre_result = $genre_stmt->get_result();
                if ($genre_result && $genre_result->num_rows > 0) {
                    $genre_row = $genre_result->fetch_assoc();
                    $genre_id = $genre_row['id'];

                    $update_query = "UPDATE books SET title = ?, author = ?, isbn = ?, genre_id = ? WHERE book_id = ?";
                    $stmt = $conn->prepare($update_query);
                    $stmt->bind_param("sssii", $title, $author, $isbn, $genre_id, $book_id);

                    if ($stmt->execute()) {
                        $success = "Book details updated successfully.";
                    } else {
                        $error = "Failed to update the book details: " . $stmt->error;
                    }
                } else {
                    $error = "Invalid genre selected.";
                }
            }
?>

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
        <button class="button_back_to_booklist" onclick="window.location.href='fe_booklist.php'">Back to Book List</button>
        <button class="button_add_book" onclick="window.location.href='book_copies.php?isbn=<?php echo $isbn; ?>'">View Copies</button>
        <div class="white-square" id="white-squareID">
            <div class="info-box">
                <h1>Edit Book Details</h1>
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
                        <form method="post">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
                                <div class="form-group-bookdetails">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="author">Author:</label>
                                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="isbn">ISBN:</label>
                                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="genre">Genre:</label>
                                    <select id="genre" name="genre">
                                        <?php foreach ($genres as $g): ?>
                                            <option value="<?php echo htmlspecialchars($g['name']); ?>" <?php echo ($g['name'] == $genre) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($g['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group-bookdetails">
                                    <button type="submit">Edit</button>
                                </div>
                                <div id="confirmation-message">
                                    <?php if (!empty($error)): ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($success)): ?>
                                        <p><?php echo $success; ?></p>
                                    <?php endif; ?>
                                </div> <!-- Confirmation message area -->
                        </form>
                    </div>
                </div>
        </div><!-- adding background -->
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
        <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals"onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks"id="button_overduebooksID"onclick="window.location.href='fe_overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_settings">
                <i class="fa-solid fa-gear" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
