<?php
include "../Code Backend/be_db_conn.php";

$results_per_page = 15;
$query = "SELECT books.title, books.author, books.isbn, genre.name AS genre, COUNT(book_copies.book_id) AS copies,
          SUM(CASE WHEN book_copies.status = 'Available' THEN 1 ELSE 0 END) AS available_copies,
          SUM(CASE WHEN book_copies.status = 'On Loan' THEN 1 ELSE 0 END) AS on_loan_copies
          FROM books
          INNER JOIN genre ON books.genre_id = genre.id
          LEFT JOIN book_copies ON books.book_id = book_copies.book_id
          GROUP BY books.book_id
          ORDER BY books.title";

$result = $conn->query($query);

$books = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

$total_books = count($books);
$total_pages = ceil($total_books / $results_per_page);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int)$_GET['page'];
} else {
    $current_page = 1;
}

if ($current_page > $total_pages) {
    $current_page = $total_pages;
}
if ($current_page < 1) {
    $current_page = 1;
}

$start_from = ($current_page - 1) * $results_per_page;

$query .= " LIMIT $start_from, $results_per_page";
$result = $conn->query($query);

$books = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <meta name="LibroFact" content="Library of Books">
    <title>LIBRIOFACT - Booklist</title>
</head>
<body>
    <div class="background">
        <div class="background_content">
            <button class="button_back_to_dashboard" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>          
            <form action="book_search_results.php" method="get">
                <div class="search-bar">
                    <input type="search" name="query" class="search-input" placeholder="Search Book ..."> 
                </div>
            </form> 
            <button class="button_add_book" onclick="window.location.href='book_add.php'">Add new Book</button>
            <div class="white-square" id="white-squareID">
                <div class="info-box">
                    <h1>Booklist</h1>
                    <p>Here you can see and manage the list of books.</p>
                </div>
                <table id="table_booklist">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Genre</th>
                <th>Copies</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book) : ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['isbn']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['copies']; ?></td>
                <td>
                <?php
                    if ($book['available_copies'] == 0) {
                        echo "All Copies on Loan";
                    } elseif ($book['available_copies'] == 1) {
                        echo $book['available_copies'] . " Copy available ";
                    } else {
                        echo $book['available_copies'] . " Copies available ";
                    }
                    ?>
                </td>
                <td>
                    <a href="book_edit.php?isbn=<?php echo $book['isbn']; ?>">Edit </a> |
                    <a href="book_copies.php?isbn=<?php echo $book['isbn']; ?>">View Copies</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                <div class="pagination">
                    <?php if ($current_page > 1): ?>
                        <a href="fe_booklist.php?page=<?php echo $current_page - 1; ?>" class="button_previous">Previous</a>
                    <?php endif; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="fe_booklist.php?page=<?php echo $current_page + 1; ?>" class="button_next">Next</a>
                    <?php endif; ?>
                </div>  
            </div>
        </div>
    </div>
    <div class="logo">
        <div class="logo_name"><p>LibrioFact</p></div>
    </div>
    <div class="topbar">
        <div> <button class="button_logout"onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar">
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='dashboard.php'"></button>
            <button class="button_equals"onclick="toggleMenu()"></button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'"></button>
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'"></button>
            <button class="button_reminder"id="button_reminderID"onclick="window.location.href='fe_reminder.php'"></button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'"></button>
            <button class="button_settings"></button>
        </div>
    </div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="Reminder"onclick="window.location.href='fe_reminder.php'">Reminder</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>