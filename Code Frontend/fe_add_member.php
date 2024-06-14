<!-- Backend Code: Funktionen und ihre Logik -->
<?php
// Einbinden der Datei, die die Verbindung zur Datenbank herstellt.
include "../Code Backend/be_db_conn.php";

// Deklarieren und Initialisieren von Variablen zum Speichern der Benutzerdaten.
$first_name = "";
$last_name = "";
$email = "";
$phone = "";

// Variablen für die Speicherung von Erfolgs- oder Fehlermeldungen.
$success = "";  
$error = "";

// Überprüfen, ob die Anfrage mit der POST-Methode gesendet wurde.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Auslesen der Daten, die aus dem Formular gesendet wurden, und Speichern in Variablen.
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Überprüfen, ob alle Felder gefüllt sind. Wenn nicht, wird eine Fehlermeldung gesetzt.
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        $error = "Alle Felder sind erforderlich";
    } else {
        // Erstellen einer SQL-Abfrage, um Daten in die Datenbank einzufügen.
        $q = "INSERT INTO `members`(`first_name`, `last_name`, `email`, `phone`) 
        VALUES ('$first_name', '$last_name', '$email', '$phone')";
        // Ausführen der SQL-Abfrage und Überprüfen des Erfolgs.
        $result = $conn->query($q);
        if ($result) {
            // Wenn alles erfolgreich verläuft, wird eine Erfolgsmeldung gesetzt.
            $success = "Mitglied erfolgreich hinzugefügt.";
            // JavaScript für die Weiterleitung zur Mitgliederliste nach erfolgreichem Hinzufügen
            echo "<script type='text/javascript'>document.location.href='fe_add_member.php';</script>";
            exit();
        } else {
            // Wenn die Abfrage fehlschlägt, wird eine Fehlermeldung gesetzt.
            $error = "Ungültige Anfrage: " . $conn->error;
        }
    }
}
?>


<!-- Frontend Code: Struktur und Navigations-Buttons der Seite sowie Site Layout generell -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Add Member</title>
    <style>
        .form-container-addmember {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .form-container-addmember h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group-addmember {
            margin-bottom: 15px;
        }

        .form-group-addmember label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group-addmember input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group-addmember button {
            width: 100%;
            padding: 10px;
            background-color: #cacaca;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        h2 {
            text-align: center;
        }


       
    </style>
</head>
<body>
    <div class="background">
    <button class="button_back_to_dashboard" onclick="window.location.href='fe_memberlist.php'">Back to Memberlist</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Member ..."> 
                </div>
            </form>
     
            
    <div class="white-square"> 
    <div class="info-box">
                    <h1>Add Member</h1>
                    <p>Here you can add new members</p>
                </div> <!-- adding background -->
    
    <div class="form-container-addmember">  
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- <div class="form-group-addmember">
        <label for="member_id">Member ID</label>
        <input type="text" id="member_id" name="member_id">
    </div> -->
    <div class="form-group-addmember">
         <label for="first_name">Firstname</label>
         <input type="text" id="first_name" name="first_name">
    </div>
    <div class="form-group-addmember">
        <label for="last_name">Lastname</label>
        <input type="text" id="last_name" name="last_name">
    </div>
    <div class="form-group-addmember">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
     </div>
     <div class="form-group-addmember">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone">
     </div>
     <div class="form-group-addmember">
        <button type="submit" name="submit">Submit</button>
    </div>
    <!-- Display error or success message --> 
    
    <?php if (!empty($success)) : ?>
            <p><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)) : ?>
            <p><?php echo $error; ?></p>
    <?php endif; ?>
    </form>

     </div>   
    </div> <!-- adding background -->      
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
    <div> <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='fe_dashboard.php'"></button>
            <button class="button_equals"onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_overduebooks"id="button_overduebooksID"onclick="window.location.href='fe_overduebooks.php'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'"></button>
            <button class="button_settings"></button>
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
 
<!-- Your HTML code here -->

