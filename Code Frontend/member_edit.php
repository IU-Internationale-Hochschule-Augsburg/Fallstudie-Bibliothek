<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Member Details</title>
</head>
<body>
    <div class="background">
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='fe_memberlist.php'">Back to Memberlist</button>
            <div class="white-square">
                <div class="info-box">
                    <h1>Member Details ändern:</h1>
                </div>
                <?php
                include "../Code Backend/be_db_conn.php";
                
                $message = ""; // Initialize message variable

                if (isset($_GET['member_id']) && is_numeric($_GET['member_id'])) {
                    $member_id = $_GET['member_id'];
                    
                    // Handle form submission
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        
                        $update_sql = "UPDATE members SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE member_id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $member_id);

                        if ($update_stmt->execute()) {
                            $message = "Daten sind aktualisiert"; // Success message
                        } else {
                            $message = "Fehler beim Aktualisieren der Daten: " . $conn->error;
                        }
                        $update_stmt->close();
                    }
                    
                    // Fetch member details
                    $sql = "SELECT * FROM members WHERE member_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $member_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($member = $result->fetch_assoc()) {
                        $first_name = htmlspecialchars($member['first_name']);
                        $last_name = htmlspecialchars($member['last_name']);
                        $email = htmlspecialchars($member['email']);
                        $phone = htmlspecialchars($member['phone']);
                    } else {
                        echo "<p>Member not found.</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Invalid request. Please provide a valid Member ID.</p>";
                }
                $conn->close();
                ?>
                <div class="detail-content">
                    <div class="form-container-addbook">
                        <form method="post">
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <div class="form-group-addbook">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                            </div>
                            <div class="form-group-addbook">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                            </div>
                            <div class="form-group-addbook">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group-addbook">
                                <label for="phone">Phone:</label>
                                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                            </div>
                            <div class="form-group-addbook">
                                <button type="submit">Save Changes</button>
                            </div>
                        </form>
                        <?php if ($message): ?>
                            <p><?php echo $message; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="logo"><div class="logo_name"><p>LibrioFact</p></div></div>
    <div class="topbar"><div> <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button></div></div>
    <div class="sidebar">
        <div class="buttons">
        <button class="button_house" id="button_houseID" onclick="window.location.href='fe_dashboard.php'"><i class="fa-solid fa-house" style="color: #0f0f0f;"></i></button>
        <button class="button_equals" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></button>
        <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.php'"><i class="fa-solid fa-book-bookmark" style="color: #030303;"></i></button>
        <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.php'"><i class="fa-solid fa-users" style="color: #000000;"></i></button>
        <button class="button_overduebooks" id="button_overduebooksID" onclick="window.location.href='fe_overduebooks.php'"><i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i></button>
        <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.php'"><i class="fa-solid fa-right-long"></i></button>
        </div>
    </div>
    <div class="menu">
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks" onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
