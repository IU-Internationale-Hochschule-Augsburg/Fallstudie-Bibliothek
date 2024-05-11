<?php
include "db_conn.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation)
    if (empty($username)) {
        header("Location: index.php?error=User Name is required");
        exit();
    }else if(empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Query the database to check if the username and password match
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Login successful
            // Redirect to home page
            header("Location: home.php"); // Change "home.php" to the URL of your home page
            exit(); // Ensure that script execution stops after redirection
        } else {
            header("Location: index.php?error=Incorrect Username or Password");
        exit();
        }
    }
}

$conn->close();
?>