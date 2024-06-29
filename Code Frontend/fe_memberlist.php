<!-- Frontend Code: Struktur und Navigations-Buttons der Seite sowie Site Layout generell -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Memberlist</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.clickable-row'); // choose all lines with clickable-row
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const memberId = this.dataset.memberId; // get ID from a line
                    window.location.href = `member_details.php?member_id=${memberId}`; // redirekting
                });
            });
        });
    </script>
     <style>
        .table-container {
            max-height: 600px; /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="background">  <!-- adding background -->  
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>          
            <form action="member_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Member ..."> 
                </div>
            </form> 
            <button class="button_add_member" onclick="window.location.href='fe_add_member.php'">Add new Member</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Memberlist</h1>
                    <p>Here you can see and manage the list of members.</p>
                </div>

                <div class="table-container">    
                
                <?php
                    include "../Code Backend/be_db_conn.php";

                    // Check if the connection to the database is successful
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Perform a query to fetch all members from the database
                    $sql = "SELECT member_id, first_name, last_name, email, phone FROM members";
                    $result = $conn->query($sql);

                    // Check if the query was successful and if there are any rows returned
                    if ($result !== false && $result->num_rows > 0) {
                        // Display the table header and iterate through the fetched results
                        echo "<table id='table_memberlist'>";
                        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='clickable-row' data-member-id='{$row["member_id"]}'>";
                            echo "<td>" . $row["member_id"] . "</td>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td><a href='member_edit.php?member_id=" . $row["member_id"] . "'>Edit</a> | <a href='member_delete.php?member_id=" . $row["member_id"] . "'>Delete</a></td>";
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
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,logout button -->
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
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>

