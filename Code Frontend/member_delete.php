<?php
include "../Code Backend/be_db_conn.php";

if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];

    // Check if the member still has open or overdue books
    $check_loans_stmt = $conn->prepare("SELECT COUNT(*) FROM loans WHERE member_id = ? AND (status = 'open' OR status = 'Overdue')");
    $check_loans_stmt->bind_param("i", $member_id);
    $check_loans_stmt->execute();
    $check_loans_stmt->bind_result($loan_count);
    $check_loans_stmt->fetch();
    $check_loans_stmt->close();

    if ($loan_count > 0) {
        // If the member still has open or overdue books, prevent deletion and show a message
        echo "The member cannot be deleted as there are still open or overdue books.";
    } else {
        // Delete the member if there are no open or overdue books
        $stmt = $conn->prepare("DELETE FROM members WHERE member_id = ?");
        $stmt->bind_param("i", $member_id);
        
        if ($stmt->execute()) {
            // Redirect back to the member list after successful deletion
            header("Location: memberlist.php");
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    // If no member ID is provided, redirect back to the member list
    header("Location: memberlist.php");
    exit();
}

$conn->close();
?>
