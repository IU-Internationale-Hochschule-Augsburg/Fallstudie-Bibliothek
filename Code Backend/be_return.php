<?php
session_start();
include "be_db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST["book_id"];
    
    // Check if the book has been issued
    $checkIssuedQuery = "SELECT * FROM issues WHERE book_id = ? AND status = 'open'";
    
    $stmt = $conn->prepare($checkIssuedQuery);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Book has been issued, proceed with return
        $updateReturnDateQuery = "UPDATE issues SET status = 'Returned', return_date = NOW() WHERE book_id = ? AND status = 'open'";
        
        $stmt = $conn->prepare($updateReturnDateQuery);
        $stmt->bind_param("i", $bookId);
        
        if ($stmt->execute()) {
            // Update book status to 'available'
            $updateBookStatusQuery = "UPDATE books SET status = 'Available' WHERE book_id = ?";
            
            $stmt = $conn->prepare($updateBookStatusQuery);
            $stmt->bind_param("i", $bookId);
            
            if ($stmt->execute()) {
                $_SESSION["message"] = "Book returned successfully!";
            } else {
                $_SESSION["message"] = "Error updating book status: " . $stmt->error;
            }
        } else {
            $_SESSION["message"] = "Error updating issue status: " . $stmt->error;
        }
    } else {
        $_SESSION["message"] = "This book is not issued!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" type="text/css" href="be_style_home.css">
    <style>
        button {
            margin-bottom: 10px; /* Add space below each button */
        }
    </style>
</head>
<body>
    <h2>Return Book</h2>
    <?php
    if (isset($_SESSION["message"])) {
        echo $_SESSION["message"];
        unset($_SESSION["message"]); // remove it after displaying
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="book_id">Book ID:</label><br>
    <input type="text" id="book_id" name="book_id"><br><br>
    <input type="submit" value="Return Book">
</form>
    <br>
    <button onclick="window.location.href='be_home.php'">Home</button>
    <br>
</body>
</html>
