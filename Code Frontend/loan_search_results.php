<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Loan Search Results</title>
    <style>
        .table-container {
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
</head>
<body>
    <div class="background">  
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='loans.php'">Back to Loan List</button>          
            <form action="loan_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ID ..."> 
                </div>
            </form> 
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Loan Search Results</h1>
                    <p>Results for your search query.</p>  
                </div>
                <div class="table-container">    
                    <?php
                        include "../Code Backend/be_db_conn.php";

                        function getLoanListByQuery($query) {
                            global $conn;

                            $query = $conn->real_escape_string($query);
                            $sql = "
                                SELECT loans.loan_id, books.title, book_copies.copy_id, members.member_id, loans.borrow_date, loans.return_date, loans.status 
                                FROM loans 
                                INNER JOIN book_copies ON loans.book_id = book_copies.copy_id
                                INNER JOIN books ON book_copies.book_id = books.book_id
                                INNER JOIN members ON loans.member_id = members.member_id
                                WHERE loans.book_id = '$query'
                                ORDER BY loans.loan_id DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table>";
                                echo "<tr><th>Loan ID</th><th>Book Title</th><th>Book ID</th><th>Member ID</th><th>Borrow Date</th><th>Return Date</th><th>Status</th></tr>";
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["loan_id"] . "</td>";
                                    echo "<td>" . $row["title"] . "</td>";
                                    echo "<td>" . $row["copy_id"] . "</td>";
                                    echo "<td>" . $row["member_id"] . "</td>";
                                    echo "<td>" . $row["borrow_date"] . "</td>";
                                    echo "<td>" . $row["return_date"] . "</td>";
                                    echo "<td>" . $row["status"] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "<p>No results found.</p>";
                            }
                        }

                        if (isset($_GET['query'])) {
                            $query = $_GET['query'];
                            getLoanListByQuery($query);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="logo"> 
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar">
        <div>
            <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button>
        </div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house" id="button_houseID" onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist" id="button_booklistID" onclick="window.location.href='booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks" id="button_overduebooksID" onclick="window.location.href='overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans" id="button_loansID" onclick="window.location.href='loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks" onclick="window.location.href='overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
