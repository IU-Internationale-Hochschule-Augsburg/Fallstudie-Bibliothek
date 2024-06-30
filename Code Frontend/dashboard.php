<?php
    include "../Code Backend/be_db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Count total number of loans

    $totalLoansQuery = "SELECT COUNT(*) AS total_loans FROM loans";
    $totalLoansResult = $conn->query($totalLoansQuery);
    $totalLoans = $totalLoansResult->fetch_assoc()['total_loans'];

    $openLoansQuery = "SELECT COUNT(*) AS open_Loans FROM loans WHERE status = 'open'";
    $openLoansResult = $conn->query($openLoansQuery);
    $openLoans = $openLoansResult->fetch_assoc()['open_Loans'];

    $totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooks = $totalBooksResult->fetch_assoc()['total_books'];

    $totalMembersQuery = "SELECT COUNT(*) AS total_members FROM members";
    $totalMembersResult = $conn->query($totalMembersQuery);
    $totalMembers = $totalMembersResult->fetch_assoc()['total_members'];
    ?>
<?php
    include "../Code Backend/be_db_conn.php";

    $results_per_page = 15;
    $query = "SELECT books.title, books.author, books.isbn, genre.name AS genre, COUNT(book_copies.book_id) AS copies,
            SUM(CASE WHEN book_copies.status = 'Available' THEN 1 ELSE 0 END) AS available_copies,
            SUM(CASE WHEN book_copies.status = 'On Loan' THEN 1 ELSE 0 END) AS on_loan_copies
            FROM books
            INNER JOIN genre ON books.genre_id = genre.id
            LEFT JOIN book_copies ON books.book_id = book_copies.book_id
            GROUP BY books.book_id
            ORDER BY books.title"; //Alphabetical Order 

    $result = $conn->query($query);

        $books = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }

        // Book Table only shows 15 books per page
        $total_books = count($books);
        $total_pages = ceil($total_books / $results_per_page);

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $current_page = (int)$_GET['page'];
        } else {
            $current_page = 1;
        }

        if ($current_page > $total_pages) {
            $current_page = $total_pages;
        }
        if ($current_page < 1) {
            $current_page = 1;
        }

        $start_from = ($current_page - 1) * $results_per_page;

        $query .= " LIMIT $start_from, $results_per_page";
        $result = $conn->query($query);

        $books = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
    $conn->close();
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
    <style>
        .info-stat-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            margin-bottom: 20px;
        }
            .info-stat {
            background-color: #cacaca;
            border-radius: 5px;
            padding: 10px;
            margin-left: 10px;
            margin-right: 10px;
            text-align: center;
            font-size: 35px;
        }
    </style>
</head>
<body>
    <div class="background">
    <div class="background_content">
        <form action="book_search_results.php" method="get">
            <div class="search-bar">
                <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
            </div>
        </form> 

        <div class="white-square" id="white-squareID">
            <?php
            echo "<div class='info-stat-container'>";
            echo "<div class='info-stat'>Total Loans: " . $totalLoans . "</div>";
            echo "<div class='info-stat'>Open Loans: " .  $openLoans . "</div>";
            echo "<div class='info-stat'>Total Books: " . $totalBooks . "</div>";
            echo "<div class='info-stat'>Total Members: " . $totalMembers . "</div>";
            echo "</div>";
            ?>

            <div class="scrollable-book-list">
            <table id="table_booklist">
            <div class="info-box">
                    <h2>Booklist</h2>
                </div>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Genre</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach ($books as $book) : ?>
                                <tr>
                                    <td><?php echo $book['title']; ?></td>
                                    <td><?php echo $book['author']; ?></td>
                                    <td><?php echo $book['isbn']; ?></td>
                                    <td><?php echo $book['genre']; ?></td>
                                    
                                </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table> 
        </div>
                             
        <div class="scrollable-member-list">
        <table id="table_memberlist">
        <div class="info-box">
                    <h2>Memberlist</h2>
                </div>
            <?php
                    include "../Code Backend/be_db_conn.php";
                    
                    // Perform a query to fetch all members from the database
                    $sql = "SELECT member_id, first_name, last_name, email, phone FROM members LIMIT 5";
                    $result = $conn->query($sql);

                    // Check if the query was successful and if there are any rows returned
                    if ($result !== false && $result->num_rows > 0) {
                        // Display the table header and iterate through the fetched results
                        echo "<table id='table_memberlist'>";
                        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["member_id"] . "</td>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            
                        }
                        echo "</table>";
                    } else {
                        echo "No members found.";
                    }

                    // Close the database connection
                    $conn->close();
                ?>
        </div>

        <div class="scrollable-loan-list">
        <table id="table_loanlist">
        <div class="info-box">
                    <h2>Loanlist</h2>
                </div>        
            <?php
                include "../Code Backend/be_overdue_status.php";
                include "../Code Backend/be_loan_list.php";
            ?>
        </div>
        
        <div class="scrollable-overdue-list">
        <table id="table_overduelist">
        <div class="info-box">
                    <h2>Overdue Booklist</h2>
                </div>        
            <?php
                    include "../Code Backend/be_overdue_list.php";
            ?>
        </div>
            

        </div>
    </div>
    </div>

    
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,logout button -->
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
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
