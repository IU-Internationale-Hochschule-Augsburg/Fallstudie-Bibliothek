<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <style>
        .button_book_list {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            background-color: #cacaca;
            color: rgb(0, 0, 0);
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 30px; /* Add margin to separate buttons */
            top: 25px;
            color: #000000;
            cursor: pointer;
            z-index: 999;
        }

        table {
            border-collapse: collapse;
            width: 97%;
            border: 1px solid #cacaca;
            margin: 0 auto;
            background-color: #cacaca;
            border-radius: 10px;
            user-select: none;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table tr {
            cursor: pointer;
        }

        table tr:first-child {
            cursor: default;
        }

        table tr:hover {
            background-color: #ddd;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #cacaca;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        

        
    </style>
    
</head>
<body>
    <div class="background">
        <button class="button_back_to_dashboard" onclick="window.location.href='fe_booklist.php'">Book List</button>

        <div class="white-square">
            <div class="info-box">
                <h1>Book Details</h1>
                <p>Here you can see and manage the details of a specific book.</p>
            </div>
            <div class="detail-content">
                <div class="form-container">
                    <?php
                    include "../Code Backend/be_db_conn.php";

                    // Check if 'book_id' parameter is set in the URL
                    if (isset($_GET['book_id'])) {
                        $book_id = $_GET['book_id'];

                        // Check if the connection to the database is successful
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Sanitize the book_id to prevent SQL injection
                        $book_id = $conn->real_escape_string($book_id);

                        // Perform a query to fetch the book details from the database
                        $sql = "SELECT * FROM books WHERE book_id = '$book_id'";
                        $result = $conn->query($sql);

                        // Check if the query was successful and if there are any rows returned
                        if ($result !== false && $result->num_rows > 0) {
                            // Fetch the book details
                            $book = $result->fetch_assoc();
                            ?>
                            <form action="submit_form.php" method="post">
                                <div class="form-group">
                                    <label for="book_id">Book ID:</label>
                                    <input type="text" id="book_id" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author:</label>
                                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN:</label>
                                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="genre">Genre:</label>
                                    <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($book['status']); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <button type="submit">Submit</button>
                                </div>
                                <div id="confirmation-message"></div> <!-- Confirmation message area -->
                            </form>
                            <?php
                        } else {
                            echo "<p>Book not found.</p>";
                        }

                        // Close the database connection
                        $conn->close();
                    } else {
                        echo "<p>No book ID specified.</p>";
                    }
                    ?>
                </div>
            </div>
        </div><!-- adding background -->
    </div>
    <div class="logo"> <!-- add logo -->
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar"><!-- adding topbar,profile button -->
        <div> <button class="button_profile">Mitarbeiter_1</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house" id="button_houseID" onclick="window.location.href='fe_dashboard.html'"></button>
            <button class="button_equals" onclick="toggleMenu()"></button>
            <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder" id="button_reminderID" onclick="window.location.href='fe_reminder.html'"></button>
            <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.html'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.php''">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.html'">Members</a></li>
            <li><a href="#" id="Reminder" onclick="window.location.href='fe_reminder.html'">Reminder</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_loans.html'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
