

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Search Results</title>
    <style>
        .white-box {
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
h2 {
    text-align: center;
}
    </style>
</head>
<body>
    <div class="background">  
    <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Book List</button>     
        <div class="white-square">
        <div class="info-box">
                    <h1>Search Result</h1>
                    <p>Here you can see the result of your search.</p>
                </div>
            <div class="search-content">               
            <?php
include "../Code Backend/be_db_conn.php";

$query = $_GET['query'];

$sql = "SELECT * FROM books WHERE title LIKE '%$query%' OR author LIKE '%$query%' OR isbn LIKE '%$query%' OR genre LIKE '%$query%' ORDER BY title ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Status</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["book_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["author"] . "</td>";
        echo "<td>" . $row["isbn"] . "</td>";
        echo "<td>" . $row["genre"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td><a href='book_edit.php?book_id=" . $row["book_id"] . "'>Edit </a> | <a href='book_delete.php?book_id=" . $row["book_id"] . "'>Delete</a></td>";
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
            <button class="button_house"id="button_houseID"onclick="window.location.href='dashboard.php'"></button>
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
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php''">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>