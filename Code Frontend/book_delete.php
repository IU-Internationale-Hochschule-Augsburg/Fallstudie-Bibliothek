<?php
    include "../Code Backend/be_db_conn.php";

        if (isset($_GET['copy_id']) && isset($_GET['isbn'])) {
            $copy_id = $_GET['copy_id'];
            $isbn = $_GET['isbn'];
            $stmt = $conn->prepare("DELETE FROM book_copies WHERE copy_id = ?");
            $stmt->bind_param("i", $copy_id);
            
            if ($stmt->execute()) {
                header("Location: book_copies.php?isbn=$isbn&message=Copy deleted successfully");
                    } else {
                        echo "Error deleting record: " . $stmt->error;
                    }
                    $stmt->close();
                    } else {
                        echo "No copy ID or ISBN provided.";
                    }

        $conn->close();
?>
