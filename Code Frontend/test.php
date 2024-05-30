<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="fe_styles.css">
<script src="fe_script.js"></script>
<meta name="LibroFact" content="Library of Books">
<style>
        .white-square {
    width: calc(100% - 2*20px); /* Subtract the left and right margins */
    height: calc(100% - 2*20px); /* Subtract the top and bottom margins */
    background-color: white;
    position: absolute;
    top: 20px; /* Add margin at the top */
    left: 20px; /* Add margin at the left */
    right: 20px; /* Add margin at the right */
    bottom: 20px; /* Add margin at the bottom */
    padding: 20px; /* Add padding inside the div */
    box-sizing: border-box; /* Include padding and border in element's total width and height */
    overflow: auto; /* Add a scrollbar if the content is too big */
}
 
table {
    border-collapse: collapse;
    width: 100%; /* Make the table take the full width of its parent */
    border: 1px solid #000; /* Add border around the table */
    max-width: 100%; /* Ensure the table does not exceed its parent's width */
    box-sizing: border-box; /* Include padding and border in element's total width */
}
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }
    .button_addbook {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    background-color: #cacaca;
    color: rgb(0, 0, 0);
    font-size: 18px;
    cursor: pointer;
    margin-bottom: 30px; /* Add margin to separate buttons */
    top: 25px; 
    color: #000000; 
    cursor: pointer; 
    z-index: 999; 
}
.button_home {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    background-color: #cacaca;
    color: rgb(0, 0, 0);
    font-size: 18px;
    cursor: pointer;
    margin-bottom: 30px; /* Add margin to separate buttons */
    top: 25px; 
    color: #000000; 
    cursor: pointer; 
    z-index: 999; 
}
.search-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.search-input, .search-button {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    background-color: #cacaca;
    color: rgb(0, 0, 0);
    font-size: 18px;
    cursor: pointer;
    margin-bottom: 30px;
}

.search-button {
    color: #000000;
}

</style>
</head>
<body>
<div class="background">
<div class="white-square">  <!-- adding background -->
<button class="button_addbook" onclick="window.location.href='test_addbook.php'">Add Book</button>
<button class="button_home" onclick="window.location.href='../Code Backend/be_home.php'">Home</button>
<div class="search-container">
    <form action="test_search_results.php" method="get">
        <input type="text" name="query" placeholder="Search books..." class="search-input">
        <input type="submit" value="Search" class="search-button">
    </form>
</div>
<br>
<br>
 
    <?php
    include "../Code Backend/be_db_conn.php";
 
    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    // Perform a query to fetch all books from the database
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
 
    // Check if the query was successful and if there are any rows returned
    if ($result !== false && $result->num_rows > 0) {
        // Display the table header and iterate through the fetched results
    echo "<table>";
    echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Status</th><th>Details</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["book_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["author"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td><button onclick=\"window.location.href='test_book_details.php?id=" . $row["book_id"] . "'\">Details</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    } else {
        // If no books are found, display a message
        echo "No books found.";
    }
 
    // Close the database connection
    $conn->close();
    ?>
<br>
</div>
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


