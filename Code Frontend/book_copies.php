<?php
    include "../Code Backend/be_db_conn.php";

        // Check if the ISBN is provided in the URL
        if (isset($_GET['isbn'])) {
            $isbn = $_GET['isbn'];

            // Fetch book details
            $query = "SELECT books.title, books.author, books.isbn, genre.name, COUNT(book_copies.book_id) AS copies
                    FROM books
                    INNER JOIN genre ON books.genre_id = genre.id
                    LEFT JOIN book_copies ON books.book_id = book_copies.book_id
                    WHERE books.isbn = '$isbn'
                    GROUP BY books.book_id";
            $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                $book = $result->fetch_assoc();
                }

            // Fetch book copies
                    $query = "SELECT * FROM book_copies WHERE book_id IN (SELECT book_id FROM books WHERE isbn = '$isbn')";
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
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
</head>
<body>
    <div class="background">
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Back to Book List</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
            <button class="button_add_book" onclick="window.location.href='book_edit.php?isbn=<?php echo $isbn; ?>'">Edit Book Details</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Book Copies</h1>
                    <p>Here you can see and manage the copies of a book.</p>
                    <button class="layer_sort" id="layer_sortID" onclick="changeIconColor()">
                        <i class="fa-solid fa-layer-group" style="color: #656567;"></i>
                    </button>
                    <button class="vertical_sort" id="vertical_sortID" onclick="changeIconColor()">
                        <i class="fa-solid fa-grip-vertical" style="color: #656567;"></i>
                    </button>                   
                </div>
                <table id="table_booklist">
        <thead>
            <tr>
                <th>Copy ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Genre</th>
                <th>Total Copies</th>
                <th>Copy Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($copies as $copy) : ?>
            <tr>
                <td><?php echo $copy['copy_id']; ?></td>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['isbn']; ?></td>
                <td><?php echo $book['name']; ?></td>
                <td><?php echo $book['copies']; ?></td>
                <td><?php echo $copy['copy_number']; ?></td>
                <td><?php echo $copy['status']; ?></td>
                <td><a href="book_delete.php?copy_id=<?php echo $copy['copy_id']; ?>&isbn=<?php echo $isbn; ?>">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>              
            </div>
        </div>
    </div>
    <div class="logo">
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar">
        <div> <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button></div>
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
