<!-- Session_start needed for interaction between the two pages for exchange of messages -->    

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>
    <style>
        .form-container-addbook {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .table-container {
            overflow-y: auto;
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
            border: 2px solid black;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group-addbook button {
            width: 100%;
            padding: 10px;
            background-color: #cacaca;
            color: black;
            border: 2px solid black;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container button {
            width: 48%;
        }

        h2 {
            text-align: center;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            box-sizing: border-box;
            align-items: center;
            border-color: #f5c6cb;
            background-color: #f8d7da;
            color: #721c24;
        }

        .message-success {
            border-color: #c3e6cb;
            background-color: #d4edda;
            color: #155724;
        }

        .message-error {
            border-color: #f5c6cb;
            background-color: #f8d7da;
            color: #721c24;
        }

        .message i {
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <div class="background">
        <button class="button_back_to_dashboard" onclick="window.location.href='loans.php'">Back to Loanlist</button>
     
        <div class="white-square"> 
            <div class="info-box">
                <h1>Loan Book</h1>
                <p>Here you can loan new books for the Member</p>
            </div>

            <div class="table-container">  
            <?php
                if (isset($_SESSION["message"])) {
                    $messages = explode("<br>", $_SESSION["message"]);
                    foreach ($messages as $message) {
                        $messageClass = 'message-error';
                        $icon = '<i class="fa fa-times"></i>';

                        if (strpos($message, 'currently') !== false ||
                            strpos($message, 'member') !== false ||
                            strpos($message, 'loan-status') !== false ||
                            strpos($message, 'book-status') !== false) {
                            $messageClass = 'message-error';
                            $icon = '<i class="fa fa-times"></i>';
                        } elseif (strpos($message, 'successfully') !== false) {
                            $messageClass = 'message-success';
                            $icon = '<i class="fa fa-check"></i>';
                        }

                        echo '<p class="message ' . $messageClass . '">' . $icon . $message . '</p>';
                    }
                    unset($_SESSION["message"]);
                }
                ?>

            <div class="form-container-addbook">  
                <form action="../Code Backend/be_loan_book.php" method="POST">
                    <div class="form-group-addbook">
                        <label for="member_id">Member-ID</label>
                        <input type="text" id="member_id" name="member_id">
                    </div>
                    <div id="bookFieldsContainer">
                        <div class="form-group-addbook book-field">
                            <label for="book_id-1">Book-ID</label>
                            <input type="text" id="book_id_1" name="book_id[]">
                        </div>
                    </div>
                    <div class="form-group-addbook button-container">
                        <button type="button" onclick="addBookField()">Add Another Book</button>
                        <button type="button" onclick="removeBookField()">Remove Last Book</button>
                    </div>
                    <div class="form-group-addbook">
                        <button type="submit" name="submit">Loan Book(s)</button>
                    </div>
                </form>
                <div id="messageContainer" class="message"></div>
            </div>   
            </div>  
        </div>      
    </div>
    <div class="logo">
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar">
        <div>
            <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button>
        </div>
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

