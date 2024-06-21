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
            ORDER BY books.title"; // Alphabetical Order 

    $result = $conn->query($query);

    $books = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    // Book Table only shows 15 books per page
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
    <meta name="LibroFact" content="Library of Books">
    <link rel="stylesheet" type="text/css" href="fe_styles.css">
    <script src="fe_script.js"></script>
    <script src="https://kit.fontawesome.com/821c8cbb42.js" crossorigin="anonymous"></script>
    <title>LIBRIOFACT - Booklist</title>

    <style>
        .sorted-row {
            background-color: #474747;
            color: white; /* Beispielhafte Änderung für kontrastierenden Text */
        }
    </style>

    <script>
        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch, sortOrder;
            table = document.getElementById("table_booklist");
            switching = true;
            sortOrder = 1; // 1 for ascending, -1 for descending, default is ascending

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                    var xValue = x.textContent.toLowerCase();
                    var yValue = y.textContent.toLowerCase();

                    if (sortOrder == 1) {
                        if (xValue > yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (xValue < yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                } else {
                    if (sortOrder === 1) {
                        sortOrder = -1;
                    } else {
                        sortOrder = 1;
                    }
                }
            }

            toggleSortIcons(columnIndex, sortOrder);
            highlightSortedRow(table, columnIndex);
        }

        function toggleSortIcons(columnIndex, sortOrder) {
            var headers = document.getElementsByTagName("th");
            for (var i = 0; i < headers.length; i++) {
                headers[i].querySelector(".fa-sort-up").classList.remove("fa-sort-up");
                headers[i].querySelector(".fa-sort-down").classList.remove("fa-sort-down");
            }

            var currentHeader = headers[columnIndex];
            var currentIcon = currentHeader.querySelector("i");

            if (sortOrder === 1) {
                currentIcon.classList.remove("fa-sort");
                currentIcon.classList.remove("fa-sort-down");
                currentIcon.classList.add("fa-sort-up");
            } else {
                currentIcon.classList.remove("fa-sort");
                currentIcon.classList.remove("fa-sort-up");
                currentIcon.classList.add("fa-sort-down");
            }
        }

        function highlightSortedRow(table, columnIndex) {
            var rows = table.rows;
            for (var i = 1; i < rows.length; i++) {
                rows[i].classList.remove("sorted-row");
            }
            var sortedRow = rows[1]; // Assuming first row is header
            var sortedCell = sortedRow.getElementsByTagName("td")[columnIndex];
            sortedRow.classList.add("sorted-row");
        }
    </script>

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
                    <button class="layer_sort" id="layer_sortID" onclick="changeIconColor()">
                        <i class="fa-solid fa-layer-group" style="color: #656567;"></i>
                    </button>
                    <button class="vertical_sort" id="vertical_sortID" onclick="changeIconColor()">
                        <i class="fa-solid fa-grip-vertical" style="color: #656567;"></i>
                    </button>
                </div>
                <table id="table_booklist">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">
                                <i class="fa-solid fa-sort"></i> Title
                            </th>
                            <th onclick="sortTable(1)">
                                <i class="fa-solid fa-sort"></i> Author
                            </th>
                            <th onclick="sortTable(2)">
                                <i class="fa-solid fa-sort"></i> ISBN
                            </th>
                            <th onclick="sortTable(3)">
                                <i class="fa-solid fa-sort"></i> Genre
                            </th>
                            <th onclick="sortTable(4)">
                                <i class="fa-solid fa-sort"></i> Copies
                            </th>
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
        <div> <button class="button_logout" onclick="window.location.href='../Code Backend/'">Logout</button></div>
    </div>
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house" id="button_houseID" onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button> 
            <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks" id="button_overduebooksID" onclick="window.location.href='fe_overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_settings">
                <i class="fa-solid fa-gear" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks" onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
