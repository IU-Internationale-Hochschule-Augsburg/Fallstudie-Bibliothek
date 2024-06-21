<?php
// Backend: Einbindung der Datenbankverbindung
include "../Code Backend/be_db_conn.php";

// Initialisierung der Variablen
$member_id = "";
$first_name = "";
$last_name = "";
$email = "";
$phone = "";

$error = "";
$success = "";

// Fetch member details if member_id is passed via URL
if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];

    // SQL-Anfrage vorbereiten
    $query = "SELECT * FROM members WHERE member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Wenn das Mitglied gefunden wird, Daten in Variablen speichern
    if ($result && $result->num_rows > 0) {
        $member = $result->fetch_assoc();
        $first_name = $member['first_name'];
        $last_name = $member['last_name'];
        $email = $member['email'];
        $phone = $member['phone'];
    } else {
        // Wenn kein Mitglied gefunden wird, zur Mitgliederliste umleiten
        header("Location: fe_memberlist.php");
        exit();
    }
}

// Mitgliedsdaten aktualisieren
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL-Update-Anfrage vorbereiten
    $update_query = "UPDATE members SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE member_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssii", $first_name, $last_name, $email, $phone, $member_id);
    // Erfolgs- oder Fehlermeldung setzen
    if ($stmt->execute()) {
        $success = "Member details updated successfully.";
    } else {
        $error = "Failed to update member details: " . $stmt->error;
    }
}
?>
<!--FRONTEND-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Edit</title>
</head>
<body>
    <div class="background">
        <button class="button_back_to_dashboard" onclick="window.location.href='dashboard.php'">Dashboard</button>
        <button class="button_back_to_booklist"  onclick="window.location.href='fe_memberlist.php'">Back to Memberlist List</button>
        <div class="white-square" id="white-squareID">
            <div class="info-box">
                <h1>Edit Member Details</h1>
                <p>Here you can see and manage the details of a specific member.</p>
                <button class="layer_sort" id="layer_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-layer-group" style="color: #656567;"></i>
                </button>
                <button class="vertical_sort" id="vertical_sortID" onclick="changeIconColor()">
                    <i class="fa-solid fa-grip-vertical" style="color: #656567;"></i>
                </button>                
            </div>
                <div class="detail-content">
                    <div class=".form-container-memberdetails">
                        <form method="post">
                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">
                                <div class="form-group-memberdetails">
                                    <label for="first_name">firstname:</label>
                                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($first_name); ?>" required>
                                </div>
                                <div class="form-group-memberdetails">
                                    <label for="last_name">lastname:</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                                </div>
                                <div class="form-group-memberdetails">
                                    <label for="email">Email:</label>
                                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                                </div>
                                <div class="form-group-memberdetails">
                                    <label for="phone">Phone:</label>
                                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                                </div>
                                <div class="form-group-memberdetailsMdm">
                                    <button type="submit">Edit</button>
                                </div>
                                <div id="confirmation-message">
                                    <?php if (!empty($error)): ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($success)): ?>
                                        <p><?php echo $success; ?></p>
                                    <?php endif; ?>
                                </div> <!-- Confirmation message area -->
                        </form>
                    </div>
                </div>
        </div><!-- adding background -->
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button></div>
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
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
