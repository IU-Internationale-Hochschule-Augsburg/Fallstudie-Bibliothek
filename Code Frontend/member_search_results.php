<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
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
    <button class="button_back_to_dashboard" onclick="window.location.href='memberlist.php'">Back to Memberlist</button>    
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Member ..."> 
                </div>
            </form>    

        <div class="white-square">
        <div class="info-box">
                    <h1>Search Result</h1>
                    <p>Here you can see the result of your search.</p>
                </div>
            <div class="search-content">               
            <?php
include "../Code Backend/be_db_conn.php";

$query = $_GET['query'];

$sql = "SELECT * FROM members WHERE first_name LIKE '%$query%' OR last_name LIKE '%$query%' OR member_id LIKE '%$query%' OR email LIKE '%$query%' ORDER BY first_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["member_id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td><a href='member_edit.php?book_id=" . $row["member_id"] . "'>Edit </a> | <a href='member_delete.php?member_id=" . $row["member_id"] . "'>Delete</a></td>";
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