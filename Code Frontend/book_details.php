<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <style>


.button_book_list {
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
table {
    border-collapse: collapse;
    width: 97%; 
    border: 1px solid #cacaca; 
    margin: 0 auto; 
    background-color: #cacaca;
    border-radius: 10px; 
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

    </style>
</head>
<body>
    <div class="background"> 
    <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Book List</button>   
        
    
    <div class="white-square">
    <div class="info-box">
                    <h1>Book Details</h1>
                    <p>Here you can see and manage the details of a specific book.</p>
                </div>
            <div class="detail-content">
                
                <?php
include "../Code Backend/be_db_conn.php";

// Check if 'book_id' parameter is set in the URL
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    
    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the book_id to prevent SQL injection
    $book_id = $conn->real_escape_string($book_id);

    // Perform a query to fetch the book details from the database
    $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = $conn->query($sql);

    // Check if the query was successful and if there are any rows returned
    if ($result !== false && $result->num_rows > 0) {
        // Fetch the book details
        $book = $result->fetch_assoc();
        
        // Start the table
        echo "<table>";
        
        // Output the headers
        echo "<tr><th>Field</th><th>Value</th><th>Edit</th></tr>";
        
        // Output the book details
        
        // Output the book details
        
        // Output the book details
        echo "<tr><td>Book ID</td><td class='value' data-field='book_id'>" . $book["book_id"] . "</td><td class='edit'>Not Editable</td></tr>";
        echo "<tr><td>Title</td><td class='value' data-field='title'>" . $book["title"] . "</td><td class='edit'>Edit</td></tr>";
        echo "<tr><td>Author</td><td class='value' data-field='author'>" . $book["author"] . "</td><td class='edit'>Edit</td></tr>";
        echo "<tr><td>ISBN</td><td class='value' data-field='isbn'>" . $book["isbn"] . "</td><td class='edit'>Edit</td></tr>";
        echo "<tr><td>Genre</td><td class='value' data-field='genre'>" . $book["genre"] . "</td><td class='edit'>Edit</td></tr>";
        echo "<tr><td>Status</td><td class='value' data-field='status'>" . $book["status"] . "</td><td class='edit'>Edit</td></tr>";
        
    
        
        // End the table
        echo "</table>";
    } else {
        echo "Book not found.";
    }
    // Close the database connection
    $conn->close();
} else {
    echo "No book ID specified.";
}
?>

        
        </div>
    </div><!-- adding background -->       
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
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.html'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.html'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php''">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>