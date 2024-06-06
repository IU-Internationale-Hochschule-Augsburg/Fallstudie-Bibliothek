<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Books</title>
    <link rel="stylesheet" type="text/css" href="be_style_home.css">
    <style>
        button {
            margin-bottom: 10px; /* Add space below each button */
        }
    </style>
    <script>
        function addBookField() {
            var container = document.getElementById('bookFieldsContainer');
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'book_ids[]'; // Use an array name
            input.placeholder = 'Enter Book ID';
            container.appendChild(input);
            container.appendChild(document.createElement('br'));
        }
    </script>
</head>
<body>

    <h2>Loan Books</h2>

    <?php
    if (isset($_SESSION["message"])) {
        echo '<p>' . $_SESSION["message"] . '</p>';
        unset($_SESSION["message"]); // remove it after displaying
    }
    ?>
   
    <form action="NEW_be_loan_book.php" method="post">

        <label for="member_id">Member ID:</label><br>
        <input type="text" id="member_id" name="member_id" required><br><br>
        <div id="bookFieldsContainer">
            <label for="book_id[]">Book IDs:</label><br>
            <input type="text" name="book_id[]" placeholder="Enter Book ID"><br>
        </div>
        <button type="button" onclick="addBookField()">Add Another Book</button><br><br>
        <input type="submit" value="Loan Books" name="loan_books">
    </form>



</body>
</html>
