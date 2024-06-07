<?php
    include "../Code Backend/be_db_conn.php";

    $title = "";
    $author = "";
    $isbn = "";
    $genre = "";


    $success = "";  
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $genre = $_POST['genre'];


        do {
            if (empty($title) || empty($author) || empty($isbn) || empty($genre)) {
                $error = "All fields are required";
                break;
            }

            $q = " INSERT INTO `books`(`title`, `author`, `isbn`, `genre`) VALUES ( '$title', '$author', '$isbn', '$genre' )";
            $result = $conn->query($q);

            if (!$result) {
                $error = "Invalid Query: " . $conn->error;
                break;
            }

            $success = $title . " added successfully";

            } while (false);
        }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Add Book</title>
    <style>
        .form-container-addbook {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .form-container-addbook h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group-addbook {
            margin-bottom: 15px;
        }

        .form-group-addbook label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group-addbook input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group-addbook button {
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
    <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Back to Booklist</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form>
     
            
    <div class="white-square"> 
    <div class="info-box">
                    <h1>Add Book</h1>
                    <p>Here you can add new books to the catalog</p>
                </div> <!-- adding background -->
    
    <div class="form-container-addbook">  
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group-addbook">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
    </div>
    <div class="form-group-addbook">
         <label for="author">Author:</label>
         <input type="text" id="author" name="author">
    </div>
    <div class="form-group-addbook">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn">
    </div>
    <div class="form-group-addbook">
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre">
     </div>
     <div class="form-group-addbook">
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
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>
 

// Backend Code



<!-- Your HTML code here -->

