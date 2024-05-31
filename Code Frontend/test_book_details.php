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
.book-details {
    width: 40%;
    border-collapse: collapse;
}

.book-details th, .book-details td {
    border: 1px solid #b0b0b0;
    padding: 8px;
}

.book-details th {
    width: 10%;
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #cacaca;
    color: black;
}
    </style>
</head>
<body>
    <div class="background"> 
        
    
    <div class="white-square">
            <div class="detail-content">
            <button class="button_book_list" onclick="window.location.href='test.php'">Book List</button>
                <h2>Book Details</h2>
            <?php
include "../Code Backend/be_db_conn.php";

$book_id = $_GET['id'];

$sql = "SELECT * FROM books WHERE book_id = $book_id";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<table class='book-details'>";
    echo "<tr><th>Title</th><td>" . $row["title"] . "</td></tr>";
    echo "<tr><th>Author</th><td>" . $row["author"] . "</td></tr>";
    echo "<tr><th>ISBN</th><td>" . $row["isbn"] . "</td></tr>";
    echo "<tr><th>Genre</th><td>" . $row["genre"] . "</td></tr>";
    echo "<tr><th>Status</th><td>" . $row["status"] . "</td></tr>";
    echo "</table>";
} else {
    echo "No book found with this ID";
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