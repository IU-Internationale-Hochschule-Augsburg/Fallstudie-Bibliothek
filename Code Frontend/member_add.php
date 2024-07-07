<!-- Backend Code: Functions and their logic -->
<?php
// Include the file that establishes the connection to the database.
include "../Code Backend/be_db_conn.php";

// Deklarieren und Initialisieren von Variablen zum Speichern der Benutzerdaten.
$first_name = "";
$last_name = "";
$email = "";
$phone = "";

// Variables for storing success or error messages.
$success = "";  
$error = "";

// Check if the request was sent using the POST method.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the data sent from the form and store it in variables.
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if all fields are filled. If not, an error message is displayed.
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        $error = "Alle Felder sind erforderlich";
    } else {
        // Create a SQL query to insert data into the database.
        $q = "INSERT INTO `members`(`first_name`, `last_name`, `email`, `phone`) 
        VALUES ('$first_name', '$last_name', '$email', '$phone')";
        // Execute the SQL query and check for success.
        $result = $conn->query($q);
        if ($result) {
            // If everything goes successfully, a success message is set.
            $success = "Mitglied erfolgreich hinzugefügt.";
            // JavaScript for redirecting to the member list after successful addition
            echo "<script type='text/javascript'>document.location.href='member_add.php';</script>";
            exit();
        } else {
            // If the query fails, an error message is set.
            $error = "Ungültige Anfrage: " . $conn->error;
        }
    }
}
?>


<!-- Frontend Code: Structure and navigation buttons of the page as well as site layout in general -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <me
    
    
    
    
    
    
    name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
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
    <button class="button_back_to_dashboard" onclick="window.location.href='memberlist.php'">Back to Memberlist</button>          
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
 
<!-- Your HTML code here -->

