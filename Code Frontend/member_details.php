<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Member Details</title>
    <style>
        /* CSS for the scrolling function of the table */
        .scrollable-table {
            max-height: 210px; /* Maximum height of the table */
            overflow-y: scroll; /* Allow vertical scrolling */
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='memberlist.php'">Back to Memberlist</button>
            <div class="white-square">
                <div class="info-box">
                    <h1>Member Details</h1>
                </div>
                <?php
                // Backend code to connect to the database and query member data
                include "../Code Backend/be_db_conn.php";
                if (isset($_GET['member_id']) && is_numeric($_GET['member_id'])) {
                    $member_id = $_GET['member_id'];
                    // SQL query to query member data
                    $sql = "SELECT * FROM members WHERE member_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $member_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($member = $result->fetch_assoc()) {
                        // Output of member data in a table
                        echo "<table id='table_booklist'>";
                        echo "<tr><th>Mitglieds-ID</th><td>" . $member['member_id'] . "</td></tr>";
                        echo "<tr><th>Vorname</th><td>" . $member['first_name'] . "</td></tr>";
                        echo "<tr><th>Nachname</th><td>" . $member['last_name'] . "</td></tr>";
                        echo "<tr><th>E-Mail</th><td>" . $member['email'] . "</td></tr>";
                        echo "<tr><th>Telefon</th><td>" . $member['phone'] . "</td></tr>";
                        echo "</table>";
                    } else {
                        echo "<p>Mitglied nicht gefunden.</p>";
                    }
                    $stmt->close();

                    //
                    //
                    //
                    //
                    // SQL query to query the borrowed books from loans table including book name and ID from books table with LEFT JOIN
                    $loans_sql = "SELECT loans.book_id, loans.borrow_date, loans.return_date, loans.status, books.title 
                                  FROM loans 
                                  LEFT JOIN books ON loans.book_id = books.book_id 
                                  WHERE loans.member_id = ?";
                    $stmt_loans = $conn->prepare($loans_sql);
                    $stmt_loans->bind_param("i", $member_id);
                    $stmt_loans->execute();
                    $loans_result = $stmt_loans->get_result();
                    $loan_count = $loans_result->num_rows; // Number of books borrowed

                    // Initialization of the status counter and then all book statuses are checked and counted
                    $status_counts = array();

                    while ($loan = $loans_result->fetch_assoc()) {
                        $status = $loan['status'];
                        if (isset($status_counts[$status])) {
                            $status_counts[$status]++;
                        } else {
                            $status_counts[$status] = 1;
                        }
                    }

                    // Always show the heading
                    echo "<h2>Anzahl der ausgeliehenen Bücher gesamt: " . $loan_count . "</h2>";

                    // Creation of status information in one line
                    $status_info = "";
                    foreach ($status_counts as $status => $count) {
                        $status_info .= "$status: $count, ";
                    }
                    // Remove the last comma and space so that you don't end up with something like Returned: 40, Overdue: 6, open: 2 ,
                    $status_info = rtrim($status_info, ', ');

                    // Display status information
                    echo "<h2>" . $status_info . "</h2>";

                    // This ensures that the borrowed books are displayed in a table
                    // The table is scrollable if it contains more books than can be displayed in 400px.
                    $loans_result->data_seek(0);

                    if ($loan_count > 0) {
                       // Display of borrowed books in a table with scroll function
                        echo "<div class='scrollable-table'>"; // Scroll-Container
                        echo "<table id='table_booklist'>";
                        echo "<tr><th>#</th><th>Buch-ID</th><th>Ausleihdatum</th><th>Rückgabedatum</th><th>Status</th><th>Buchtitel</th></tr>";
                        $counter = 1;
                        while ($loan = $loans_result->fetch_assoc()) {
                            // Check if the title is empty and replace accordingly
                            $title = $loan['title'] ? $loan['title'] : 'Unbekannter Titel';
                            echo "<tr><td>" . $counter . "</td><td>" . $loan['book_id'] . "</td><td>" . $loan['borrow_date'] . "</td><td>" . $loan['return_date'] . "</td><td>" . $loan['status'] . "</td><td>" . $title . "</td></tr>";
                            $counter++;
                        }
                        echo "</table>";
                        echo "</div>"; // End of scroll container
                    }
                    $stmt_loans->close();
                } else {
                    echo "<p>Ungültige Anforderung. Bitte geben Sie eine gültige Mitglieds-ID an.</p>";
                }
                $conn->close();
                ?>
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
</html>
