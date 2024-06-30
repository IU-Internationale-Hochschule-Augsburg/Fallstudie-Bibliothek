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

<style>
    .search-content{
            max-height: 600px; /* Adjust height as needed */
            overflow-y: auto;
        }

    table {
        border-collapse: collapse;
        width: 97%; 
        border: 1px solid #cacaca; 
        margin: 0 auto; 
        background-color: #cacaca;
        user-select: none; 
    }

    table th,
    table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    table tr {
        cursor: pointer;
    }

    table  tr:first-child {
        cursor: default; 
    }

    table tr:hover {
        background-color: #ddd; 
    }
    h2 {
        text-align: center;
    }
</style>

<body>
    <div class="background">  
        <button class="button_back_to_dashboard" onclick="window.location.href='booklist.php'">Book List</button>    
        <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
        <button class="button_add_book" onclick="window.location.href='book_add.php'">Add new Book</button> 
        <div class="white-square">
            <div class="info-box">
                        <h1>Search Result</h1>
                        <p>Here you can see the result of your search.</p>                      
            </div>
                <div class="search-content">               
                        <?php
                        include "../Code Backend/be_db_conn.php";

                            $query = $_GET['query'];

                            $sql = "SELECT books.*, genre.name AS genre 
                                    FROM books 
                                    INNER JOIN genre ON books.genre_id = genre.id 
                                    WHERE books.title LIKE '%$query%' OR books.author LIKE '%$query%' OR books.isbn LIKE '%$query%' OR genre.name LIKE '%$query%' 
                                    ORDER BY books.title ASC";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table>";
                                echo "<tr><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Action</th></tr>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["title"] . "</td>";
                                    echo "<td>" . $row["author"] . "</td>";
                                    echo "<td>" . $row["isbn"] . "</td>";
                                    echo "<td>" . $row["genre"] . "</td>";
                                    echo "<td><a href='book_edit.php?isbn=" . $row["isbn"] . "'>Edit</a> | <a href='book_copies.php?isbn=" . $row["isbn"] . "'>View Copies</a></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "No results found";
                            }
                    ?>
                </div>
        </div>
        <!-- adding background -->       
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