<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <style>
        .white-square {
        width: calc(100% - 2*20px); /* Subtract the left and right margins */
        height: calc(100% - 2*20px); /* Subtract the top and bottom margins */
        background-color: #f0f0f0;
        position: absolute;
        top: 20px; /* Add margin at the top */
        left: 20px; /* Add margin at the left */
        right: 20px; /* Add margin at the right */
        bottom: 20px; /* Add margin at the bottom */
        padding: 20px; /* Add padding inside the div */
        box-sizing: border-box; /* Include padding and border in element's total width and height */
        overflow: auto; /* Add a scrollbar if the content is too big */
}
h2 {
    text-align: center;
}
.info-box-container {
    display: flex;
    justify-content: center; /* Align the boxes in the center */
    flex-wrap: wrap; /* Allow the boxes to wrap onto multiple lines */
}

.info-box {
    display: inline-block;
    margin: 20px; /* Increase the margin to add more space between the boxes */
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    width: 200px; /* Increase the width to make the boxes bigger */
    text-align: center;
    border-radius: 10px;
    background-color: grey;
    color: white;
    font-weight: bold;
}
table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Add border around the table */
        }
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }

        .info-table th, .info-table td {
    width: 20%; /* Adjust this value to fit your needs */
    text-align: left;
}




    </style>
</head>
<body>
    <div class="background"> 
    <div class="white-square">  <!-- adding background -->
        <div class="add_book_content">
            <h2>Dashboard</h2>
            <?php
    include "../Code Backend/be_db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Count total number of loans
    $totalLoansQuery = "SELECT COUNT(*) AS total_loans FROM issues";
    $totalLoansResult = $conn->query($totalLoansQuery);
    $totalLoans = $totalLoansResult->fetch_assoc()['total_loans'];

    $openLoansQuery = "SELECT COUNT(*) AS open_Loans FROM issues WHERE status = 'open'";
    $openLoansResult = $conn->query($openLoansQuery);
    $openLoans = $openLoansResult->fetch_assoc()['open_Loans'];

    $totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooks = $totalBooksResult->fetch_assoc()['total_books'];

    $totalMembersQuery = "SELECT COUNT(*) AS total_members FROM members";
    $totalMembersResult = $conn->query($totalMembersQuery);
    $totalMembers = $totalMembersResult->fetch_assoc()['total_members'];


    
    echo "<div class='info-box-container'>";
    echo "<div class='info-box'>Total Loans: " . $totalLoans . "</div>";
    echo "<div class='info-box'>Open Loans: " .  $openLoans . "</div>";
    echo "<div class='info-box'>Total Books: " . $totalBooks . "</div>";
    echo "<div class='info-box'>Total Members: " . $totalMembers . "</div>";
    echo "</div>";

    // Fetch 5 books from the database
    $sqlBooks = "SELECT * FROM books LIMIT 5";
    $resultBooks = $conn->query($sqlBooks);

    echo "<h3>Books</h3>";
    if ($resultBooks !== false && $resultBooks->num_rows > 0) {
        echo "<table class='info-table'>";
        echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Status</th></tr>";
        while ($row = $resultBooks->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["book_id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["author"] . "</td>";
            echo "<td>" . $row["genre"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No books found.";
    }

     // Fetch 5 members from the database
     $sqlMembers = "SELECT * FROM members LIMIT 5";
     $resultMembers = $conn->query($sqlMembers);
 
     echo "<h3>Members</h3>";
     if ($resultMembers !== false && $resultMembers->num_rows > 0) {
         echo "<table class='info-table'>";
         echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th></tr>";
         while ($row = $resultMembers->fetch_assoc()) {
             echo "<tr>";
             echo "<td>" . $row["member_id"] . "</td>";
             echo "<td>" . $row["first_name"] . "</td>";
             echo "<td>" . $row["last_name"] . "</td>";
             echo "<td>" . $row["email"] . "</td>";
             echo "<td>" . $row["phone"] . "</td>";
             echo "</tr>";
         }
         echo "</table>";
     } else {
         echo "No members found.";
     }
    ?>

    
        </div>
    </div> <!-- adding background -->       
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_profile">Mitarbeiter_1</button></div>
    </div> 
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.html'"></button>
            <button class="button_equals" onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.html'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.html'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.html'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php''">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.html'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>