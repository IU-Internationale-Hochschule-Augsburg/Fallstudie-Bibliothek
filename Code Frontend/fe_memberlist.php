<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
</head>
<body>
    <div class="background">  <!-- adding background -->  
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='fe_dashboard.html'">Back to Dashboard</button>          
            <form action="suche.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Member ..."> 
                </div>
            </form> 
            <button class="button_add_member" onclick="window.location.href='fe_add_member.html'">Add new Member</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Memberlist</h1>
                    <p>Here you can see and manage the list of members.</p>
                </div>
                <?php
                    include "../Code Backend/be_db_conn.php";

                    // Check if the connection to the database is successful
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Perform a query to fetch all books from the database
                    $sql = "SELECT * FROM members";
                    $result = $conn->query($sql);

                    // Check if the query was successful and if there are any rows returned
                    if ($result !== false && $result->num_rows > 0) {
                        // Display the table header and iterate through the fetched results
                        echo "<table id='table_memberlist'>"; 
                        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th></tr>";
                        while ($row = $result->fetch_assoc()) {
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
                        // If no members are found, display a message
                        echo "No members found.";
                    }                

                    // Close the database connection
                    $conn->close();
                ?>
            </div>
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
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.html'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.html'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>
