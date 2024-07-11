<?php
include "../Code Backend/be_db_conn.php";

if (isset($_GET['copy_id']) && isset($_GET['isbn'])) {
    $copy_id = intval($_GET['copy_id']);
    $isbn = htmlspecialchars($_GET['isbn']);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete the book copy
        $delete_copy_query = "DELETE FROM book_copies WHERE copy_id = ?";
        $stmt = $conn->prepare($delete_copy_query);
        $stmt->bind_param("i", $copy_id);
        $stmt->execute();
        $stmt->close();

        // Check if there are any copies left for the book
        $check_copies_query = "SELECT COUNT(*) as copies_count FROM book_copies WHERE book_id = (SELECT book_id FROM books WHERE isbn = ?)";
        $stmt = $conn->prepare($check_copies_query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        $copies_count = $result->fetch_assoc()['copies_count'];
        $stmt->close();

        // If no copies left, delete the book
        if ($copies_count == 0) {
            $delete_book_query = "DELETE FROM books WHERE isbn = ?";
            $stmt = $conn->prepare($delete_book_query);
            $stmt->bind_param("s", $isbn);
            $stmt->execute();
            $stmt->close();
        }

        // Commit the transaction
        $conn->commit();
        
        // Redirect back to the book list page with a success message
        header("Location: booklist.php?message=Book copy deleted successfully.");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    // If no copy_id or isbn is provided, redirect back to the booklist page
    header("Location: booklist.php");
    exit();
}
?>
