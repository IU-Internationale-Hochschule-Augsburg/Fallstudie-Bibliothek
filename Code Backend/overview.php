<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Overview</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Add border around the table */
        }
        th, td {
            border: 1px solid #000; /* Add border around table cells */
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Overview </h2>
    <?php
    include "be_db_conn.php";

    // Check if the connection to the database is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Count total number of issues
    $totalIssuesQuery = "SELECT COUNT(*) AS total_issues FROM issues";
    $totalIssuesResult = $conn->query($totalIssuesQuery);
    $totalIssues = $totalIssuesResult->fetch_assoc()['total_issues'];

    $totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooks = $totalBooksResult->fetch_assoc()['total_books'];

    $totalMembersQuery = "SELECT COUNT(*) AS total_members FROM members";
    $totalMembersResult = $conn->query($totalMembersQuery);
    $totalMembers = $totalMembersResult->fetch_assoc()['total_members'];

    echo "<p>Total Issues: " . $totalIssues . "</p>";
    echo "<p>Total Books: " . $totalBooks . "</p>";
    echo "<p>Total Members: " . $totalMembers . "</p>";
    ?>

    <br>
    <button onclick="window.location.href='be_home.php'">Home</button><br><br>
    <button onclick="window.location.href='be_loan.php'">Loan Book</button>
    <button onclick="window.location.href='be_return.php'">Return Book</button>
    <button onclick="window.location.href='be_loan_list.php'">Loan List</button>
    <button onclick="window.location.href='be_book_management.php'">Book Management</button>
    <button onclick="window.location.href='be_book_list.php'">Book List</button>
    <button onclick="window.location.href='be_member_management.php'">Member Management</button>
    <button onclick="window.location.href='be_member_list.php'">Member List</button>
    <button onclick="window.location.href='be_user_management.php'">User Management</button>
    <button onclick="window.location.href='overview.php'">Overview</button>
    <br>
    <br>

    

    <?php
    // Fetch the 5 most recent issues from the database
    
    
    $sqlIssues = "
    SELECT issues.issue_id, books.title, members.first_name, members.last_name, issues.issue_date, issues.return_date, issues.status 
    FROM issues 
    INNER JOIN books ON issues.book_id = books.book_id 
    INNER JOIN members ON issues.member_id = members.member_id 
    ORDER BY issues.issue_date DESC, issues.issue_id DESC 
    LIMIT 5";

    $resultIssues = $conn->query($sqlIssues);

    echo "<h3>Recent Issues</h3>";
    if ($resultIssues !== false && $resultIssues->num_rows > 0) {
        echo "<table>";
      
    echo "<tr><th>Issue ID</th><th>Book Title</th><th>Member Name</th><th>Issue Date</th><th>Return Date</th><th>Status</th></tr>";
    while ($row = $resultIssues->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["issue_id"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["issue_date"] . "</td>";
        echo "<td>" . $row["return_date"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "</tr>";
}

        echo "</table>";
    } else {
        echo "No issues found.";
    }
    ?>

    <br>
    <button onclick="window.location.href='be_loan_list.php'">Loan List</button>
    <button onclick="window.location.href='be_loan.php'">Loan Book</button>
    <br>
    <br>

    <?php
    // Fetch 5 books from the database
    $sqlBooks = "SELECT * FROM books LIMIT 5";
    $resultBooks = $conn->query($sqlBooks);

    echo "<h3>Books</h3>";
    if ($resultBooks !== false && $resultBooks->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Status</th></tr>";
        while ($row = $resultBooks->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["book_id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["author"] . "</td>";
            echo "<td>" . $row["isbn"] . "</td>";
            echo "<td>" . $row["genre"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No books found.";
    }
    ?>

    <br>
    <button onclick="window.location.href='be_book_list.php'">Book List</button>
    <button onclick="window.location.href='be_book_management.php'">Book Management</button>
    <br>
    <br>

    <?php
    // Fetch 5 members from the database
    $sqlMembers = "SELECT * FROM members LIMIT 5";
    $resultMembers = $conn->query($sqlMembers);

    echo "<h3>Members</h3>";
    if ($resultMembers !== false && $resultMembers->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th></tr>";
        while ($row = $resultMembers->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["member_id"] . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No members found.";
    }
    ?>

    <br>
    <button onclick="window.location.href='be_member_list.php'">Member List</button>
    <button onclick="window.location.href='be_member_management.php'">Member Management</button>
    <br>
    <br>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

