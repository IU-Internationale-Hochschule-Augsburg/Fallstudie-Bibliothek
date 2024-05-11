<?php
include "db_conn.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST["book_id"];
    $memberId = $_POST["member_id"];
    
    // Check if the book is currently issued
    $issuedBooksQuery = "SELECT * FROM issues WHERE book_id = $bookId AND return_date > NOW()";
    $issuedBooksResult = $conn->query($issuedBooksQuery);
    
    if ($issuedBooksResult->num_rows > 0) {
        // Book is already issued, display error message
        echo "This book is already issued and not returned yet.";
    } else {
        // Proceed with issuing the book
        $issueDate = date("Y-m-d");
        $returnDate = date("Y-m-d", strtotime("+14 days")); // Assuming a 14-day loan period
        
        // Insert issuance record into the issues table
        $insertIssueQuery = "INSERT INTO issues (book_id, member_id, issue_date, return_date) VALUES ('$bookId', '$memberId', '$issueDate', '$returnDate')";
        $conn->query($insertIssueQuery);
        
        // Update the status of the book to 'issued' in the books table
        $updateBookStatusQuery = "UPDATE books SET status = 'issued' WHERE book_id = $bookId";
        $conn->query($updateBookStatusQuery);
        
        echo "Book issued successfully!";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
</head>
<body>

    <h2>Issue Book</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="book_id">Book ID:</label><br>
        <input type="text" id="book_id" name="book_id"><br>
        <label for="member_id">Member ID:</label><br>
        <input type="text" id="member_id" name="member_id"><br><br>
        <input type="submit" value="Issue Book" name="issue_book">
    </form>

    <br>
    <button onclick="window.location.href='home.php'">Home</button>
    <br>
    <a href="logout.php" class="logout-button">Logout</a>

</body>
</html>

