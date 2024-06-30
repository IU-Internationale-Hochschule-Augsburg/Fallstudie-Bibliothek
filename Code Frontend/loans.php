<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Loanlist</title>
    <style>
        .table-container {
          overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="background">  
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='return_book.php'">Return Book</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
            <button class="button_add_book" onclick="window.location.href='loan_book.php'">Loan Book</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Loanlist</h1>
                    <p>Here you can see and manage the list of loaned books.</p>  
                </div>
                <div class="table-container">    
                    <?php
                        include "../Code Backend/be_overdue_status.php";
                        include "../Code Backend/be_loan_list.php";
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
    <script>
        function adjustTableContainerHeight() {
            const tableContainer = document.querySelector('.table-container');
            const windowHeight = window.innerHeight;
            const containerHeight = windowHeight * 0.6; // 60% der Fensterhöhe
            tableContainer.style.maxHeight = containerHeight + 'px';
        }

        window.addEventListener('resize', adjustTableContainerHeight);
        window.addEventListener('load', adjustTableContainerHeight); // Höhe beim initialen Laden anpassen
        document.addEventListener('DOMContentLoaded', adjustTableContainerHeight); // Höhe anpassen, wenn DOM geladen ist
    </script>
</body>
</html>
