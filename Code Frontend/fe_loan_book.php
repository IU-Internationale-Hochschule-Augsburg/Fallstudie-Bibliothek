<!-- Session_start nötig, damit die Nachrichten zwischen den beiden Klasssen
 versendet werden können.-->

<?php
session_start();
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
    </style>
</head>
<body>
    <div class="background">
        <button class="button_back_to_dashboard" onclick="window.location.href='fe_loans.php'">Back to Loanlist</button>
     
        <div class="white-square"> 
            <div class="info-box">
                <h1>Loan Book</h1>
                <p>Here you can loan new books for the Member</p>
            </div>

            <!--Dieser PHP-Code wird benötigt, um die Nachricht anzuzeigen, 
            dass ein Buch erfolgreich ausgeliehen wurde. Muss evtl. noch an eine andere Stelle 
            geschoben werden -- Absprache mit Flo! -->
    
            <?php
            if (isset($_SESSION["message"])) {
                echo '<p>' . $_SESSION["message"] . '</p>';
                unset($_SESSION["message"]); // remove it after displaying
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
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='fe_dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>

    <script>
        
        function addBookField() {
            const container = document.getElementById('bookFieldsContainer');
            if (container.children.length < 5) {
                const index = container.children.length + 1;
                const newField = document.createElement('div');
                newField.className = 'form-group-addbook book-field';
                newField.innerHTML = `
                    <label for="book_id_${index}">Book-ID</label>
                    <input type="text" id="book_id_${index}" name="book_id[]">
                `;
                container.appendChild(newField);
            } else {
                alert("You can only add up to 5 books at a time.");
            }
        }

        function removeBookField() {
            const container = document.getElementById('bookFieldsContainer');
            if (container.children.length > 1) {
                container.removeChild(container.lastChild);
            }
        }


    </script>
</body>
</html>
