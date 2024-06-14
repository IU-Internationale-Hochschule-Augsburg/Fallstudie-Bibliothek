<?php
include "../Code Backend/be_db_conn.php";

$member_id = "";
$first_name = "";
$last_name = "";
$email = "";
$phone = "";

$error = "";
$success = "";

// Fetch member details if member_id is passed via URL
if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];

    $query = "SELECT * FROM members WHERE member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $member = $result->fetch_assoc();
        $first_name = $member['first_name'];
        $last_name = $member['last_name'];
        $email = $member['email'];
        $phone = $member['phone'];
    } else {
        header("Location: fe_memberlist.php");
        exit();
    }
}

// Update member details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_query = "UPDATE members SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE member_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssii", $first_name, $last_name, $email, $phone, $member_id);

    if ($stmt->execute()) {
        $success = "Member details updated successfully.";
    } else {
        $error = "Failed to update member details: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <title>LIBRIOFACT - Edit Member</title>
</head>
<body>
    <div class="background">
        <button class="button_back_to_memberlist" onclick="window.location.href='fe_memberlist.php'">Back to Member List</button>
        <div class="white-square">
            <div class="info-box">
                <h1>Edit Member Details</h1>
                <p>Here you can update the details of a specific member.</p>
            </div>
            <div class="form-container-memberdetails">
                <form method="post">
                    <div class="form-group-memberdetails">
                        <label for="first_name">Firstname:</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="form-group-memberdetails">
                        <label for="last_name">Lastname:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="form-group-memberdetails">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group-memberdetails">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="form-group-memberdetails">
                        <button type="submit">Edit</button>
                    </div>
                    <div id="confirmation-message">
                        <?php if (!empty($error)): ?>
                            <p><?php echo $error; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                            <p><?php echo $success; ?></p>
                        <?php endif; ?>
                    </div> <!-- Confirmation message area -->
                </form>
            </div>
        </div><!-- adding background -->
    </div>
</body>
</html>
