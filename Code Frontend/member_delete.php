<?php
include "../Code Backend/be_db_conn.php";

if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];
    $stmt = $conn->prepare("DELETE FROM members WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    
    if ($stmt->execute()) {
        // Redirect back to the list of participants after successful deletion
        header("Location: memberlist.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
} else {
    // If no participant ID is provided, redirect back to the list of participants
    header("Location: memberlist.php");
    exit();
}

$conn->close();
?>
