<?php
include "../Code Backend/be_db_conn.php";

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
                    $error = "Failed to update the copies count in the book table: " . $conn->error;
                }

                // Add a new copy of the book to the book_copy table with the incremented copy number
                $insert_copy_query = $conn->prepare("INSERT INTO book_copies (book_id, copy_number, status) SELECT ?, MAX(copy_number) + 1, 'Available' FROM book_copies WHERE book_id = ?");
                $insert_copy_query->bind_param("ii", $book_id, $book_id);
                $result_copy = $insert_copy_query->execute();
                if ($result_copy) {
                    $success = "A new copy of the existing book has been added successfully.";
                } else {
                    $error = "Failed to add a copy of the existing book to the book_copy table: " . $conn->error;
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
                        $success = "A new book " .  $title . " has been added successfully.";
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
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Add Book</title>
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
            
                <div class="form-container-addbook">  
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group-addbook">
                            <label for="isbn">ISBN:</label>
                            <input type="text" id="isbn" name="isbn">
                        </div>
                        <div class="form-group-addbook">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title">
                        </div>
                        <div class="form-group-addbook">
                            <label for="author">Author:</label>
                            <input type="text" id="author" name="author">
                        </div>
                        <div class="form-group-addbook">
                            <label for="genre">Gemre:</label>
                            <select id="genre" name="genre">
                                <option value="Fantasy">Fantasy</option>
                                <option value="History">History</option>
                                <option value="Romance">Romance</option>
                                <option value="Science Fiction">Science Fiction</option>
                                <option value="Science">Science</option>
                                <option value="Sport">Sport</option>
                            </select>
                        </div>
                    
                        <div class="form-group-addbook">
                            <button type="submit" name="submit">Submit</button>
                        </div>
                        <!-- Display error or success message -->  
                        <?php if (!empty($success)) : ?>
                                <p><?php echo $success; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($error)) : ?>
                                <p><?php echo $error; ?></p>
                        <?php endif; ?>
                    </form>
                </div>   
        </div> <!-- adding background -->      
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
    <div> <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.php'"></button>
            <button class="button_equals"onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_overduebooks"id="button_overduebooksID"onclick="window.location.href='fe_overduebooks.php'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue Books</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
 

// Backend Code



<!-- Your HTML code here -->

