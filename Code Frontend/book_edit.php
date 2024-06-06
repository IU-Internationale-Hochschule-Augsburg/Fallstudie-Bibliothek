<?php
    include "../Code Backend/be_db_conn.php";

    $book_id = "";
    $title = "";
    $author = "";
    $isbn = "";
    $genre = "";
    $status = "";

    $error ="";
    $success ="";
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(!isset($_GET['book_id'])){
            header('location:fe_booklist.php');
            exit;
        }
        $book_id = $_GET['book_id'];
        $q = "SELECT * FROM `books` WHERE book_id = '$book_id'";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        
        while(!$row) {
            header('location:fe_booklist.php');
            exit;
        }

        $title = $row['title'];
        $author = $row['author'];
        $isbn = $row['isbn'];
        $genre = $row['genre'];
        $status = $row['status'];
    }

    else {
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $genre = $_POST['genre'];
        $status = $_POST['status'];
        
        $q = "UPDATE `books` SET `title`='$title',`author`='$author',`isbn`='$isbn',`genre`='$genre' WHERE book_id = '$book_id'";
    if ($conn->query($q) === TRUE) {
        $success = "Book updated successfully";
    } else {
        $error = "Error updating book: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>

    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Book Details</title>
</head>

<body>
    <div class="background">
        <button class="button_back_to_booklist" onclick="window.location.href='fe_booklist.php'">Back to Book List</button>
        <button class="button_add_book" onclick="window.location.href='book_add.php'">Add new Book</button>
        <div class="white-square" id="white-squareID">
            <div class="info-box">
                <h1>Edit Book Details</h1>
                <p>Here you can see and manage the details of a specific book.</p>
            </div>
            <div class="detail-content">
                <div class="form-container-bookdetails">
                            <form method="post">
                                <div class="form-group-bookdetails">
                                    <label for="book_id">Book ID:</label>
                                    <input type="text" id="book_id" name="book_id" value="<?php echo $book_id; ?>"" readonly>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" value="<?php echo $title; ?>"" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="author">Author:</label>
                                    <input type="text" id="author" name="author" value="<?php echo $author; ?>"" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="isbn">ISBN:</label>
                                    <input type="text" id="isbn" name="isbn" value="<?php echo $isbn; ?>"" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="genre">Genre:</label>
                                    <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>"" required>
                                </div>
                                <div class="form-group-bookdetails">
                                    <label for="status">Status:</label>
                                    <input type="text" id="status" name="status" value="<?php echo $status; ?>"" readonly>
                                </div>
                                <div class="form-group-bookdetails">
                                    <button type="submit">Edit</button>
                                </div>
                                <div id="confirmation-message"><?php echo "$success"?></div> <!-- Confirmation message area -->
                            </form>
                </div>
            </div>
        </div><!-- adding background -->
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
            <button class="button_equals"onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.php'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.php'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
