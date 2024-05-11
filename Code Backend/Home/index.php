<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="overlay">
        <div class="container">
            <img class="fit-picture" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIM_-ALM6Bdf_nG45MtE2jeO-oq2K1nDoIAg&s" alt="PersonaIcon" />
            <label class="login-text">Log In</label><br>
            <form action="index.php" method="post">
                <div class="stacked">
                    <input class="input1" type="text" name="username" placeholder="Username">
                    <input class="input2" type="password" name="password" placeholder="Password">
                </div>
                <button class="button" type="submit">SIGN IN</button>
                <!-- Display error message if exists -->
                <?php if (isset($_GET['error'])) : ?>
                    <div class="error"><?php echo $_GET['error']; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
   
   
   
   
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
        } else if (empty($password)) {
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
</body>
</html>
