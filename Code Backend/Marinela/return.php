<?php
include "db_conn.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST["book_id"];
    
    // Check if the book has been issued
    $checkIssuedQuery = "SELECT * FROM issues WHERE book_id = ? AND return_date > NOW()";
    
    $stmt = $conn->prepare($checkIssuedQuery);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Book has been issued, proceed with return
        $updateReturnDateQuery = "UPDATE issues SET return_date = NOW() WHERE book_id = ? AND return_date > NOW()";
        
        $stmt = $conn->prepare($updateReturnDateQuery);
        $stmt->bind_param("i", $bookId);
        
        if ($stmt->execute()) {
            // Update book status to 'available'
            $updateBookStatusQuery = "UPDATE books SET status = 'available' WHERE book_id = ?";
            
            $stmt = $conn->prepare($updateBookStatusQuery);
            $stmt->bind_param("i", $bookId);
            
            if ($stmt->execute()) {
                $message = "Book returned successfully!";
            } else {
                $message = "Error updating book status: " . $conn->error;
            }
        } else {
            $message = "Error updating return date: " . $conn->error;
        }
    } else {
        // Book has not been issued, cannot return
        $message = "Book has not been issued.";
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
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <style>
        button {
            margin-bottom: 10px; /* Add space below each button */
        }
    </style>
</head>
<body>
    <h2>Return Book</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="book_id">Book ID:</label><br>
        <input type="text" id="book_id" name="book_id"><br><br>
        <input type="submit" value="Return Book">
    </form>
    <br>
    <button onclick="window.location.href='home.php'">Home</button>
    <br>
    <?php echo $message; ?>
    <br>
    
</body>
</html>
