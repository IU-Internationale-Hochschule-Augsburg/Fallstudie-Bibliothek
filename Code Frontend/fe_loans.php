<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Booklist</title>
</head>
<body>
    <div class="background">  
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='fe_return_book.php'">Return Book</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
            <button class="button_add_book" onclick="window.location.href='fe_loan_book.php'">Loan Book</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Loanlist</h1>
                    <p>Here you can see and manage the list of loaned books.</p>
                </div>

                <!-- PHP code for the loan list will go here -->

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
    <div class="sidebar">
        <div class="buttons">
            <button class="button_house" id="button_houseID" onclick="window.location.href='dashboard.php'"></button>
            <button class="button_equals" onclick="toggleMenu()"></button>
            <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder" id="button_reminderID" onclick="window.location.href='fe_reminder.php'"></button>
            <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.php'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder" onclick="window.location.href='fe_reminder.php'">Reminder</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
