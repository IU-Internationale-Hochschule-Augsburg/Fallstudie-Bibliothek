<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Member Details</title>
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
</head>
<body>
    <div class="background">
        <div class="background_content">
        <button class="button_back_to_dashboard" onclick="window.location.href='fe_memberlist.php'">Back to Memberlist</button>          

            <div class="white-square">
                <div class="info-box">
                    <h1>Member Details</h1>
                </div>
                <?php
                include "../Code Backend/be_db_conn.php";
                if (isset($_GET['member_id']) && is_numeric($_GET['member_id'])) {
                    $member_id = $_GET['member_id'];
                    $sql = "SELECT * FROM members WHERE member_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $member_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($member = $result->fetch_assoc()) {
                        echo "<table id='table_member_details'>";
                        echo "<tr><th>Member ID</th><td>" . $member['member_id'] . "</td></tr>";
                        echo "<tr><th>First Name</th><td>" . $member['first_name'] . "</td></tr>";
                        echo "<tr><th>Last Name</th><td>" . $member['last_name'] . "</td></tr>";
                        echo "<tr><th>Email</th><td>" . $member['email'] . "</td></tr>";
                        echo "<tr><th>Phone</th><td>" . $member['phone'] . "</td></tr>";
                        echo "</table>";
                    } else {
                        echo "<p>Member not found.</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Invalid request. Please provide a valid Member ID.</p>";
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
        <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.php'">
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
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
