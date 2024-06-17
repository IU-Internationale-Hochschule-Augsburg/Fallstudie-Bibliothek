<?php
    include "../Code Backend/be_db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Count total number of loans
    $totalLoansQuery = "SELECT COUNT(*) AS total_loans FROM NEW_loans";
    $totalLoansResult = $conn->query($totalLoansQuery);
    $totalLoans = $totalLoansResult->fetch_assoc()['total_loans'];

    $openLoansQuery = "SELECT COUNT(*) AS open_Loans FROM NEW_loans WHERE status = 'open'";
    $openLoansResult = $conn->query($openLoansQuery);
    $openLoans = $openLoansResult->fetch_assoc()['open_Loans'];

    $totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooks = $totalBooksResult->fetch_assoc()['total_books'];

    $totalMembersQuery = "SELECT COUNT(*) AS total_members FROM members";
    $totalMembersResult = $conn->query($totalMembersQuery);
    $totalMembers = $totalMembersResult->fetch_assoc()['total_members'];
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
    <div class="background">  <!-- adding background -->  
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
