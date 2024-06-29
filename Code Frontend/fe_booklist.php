<?php
    include "../Code Backend/be_db_conn.php";

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

    // Sort array if sort request is present
    if (isset($_GET['sort']) && isset($_GET['order'])) {
        $sort = $_GET['sort'];
        $order = $_GET['order'];

        usort($books, function ($a, $b) use ($sort, $order) {
            if ($order == 'asc') {
                return strcmp($a[$sort], $b[$sort]);
            } else {
                return strcmp($b[$sort], $a[$sort]);
            }
        });
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
        th.sorted-asc, th.sorted-desc {
            background-color: #f0f0f0;
        }
        .table-container {
            max-height: 600px; /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const getSortParams = (th) => {
                const column = th.dataset.column;
                const order = th.classList.contains('sorted-asc') ? 'desc' : 'asc';
                return { column, order };
            };

            document.querySelectorAll('th').forEach(th => {
                th.addEventListener('click', () => {
                    const sortParams = getSortParams(th);
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('sort', sortParams.column);
                    urlParams.set('order', sortParams.order);
                    window.location.search = urlParams.toString();
                });
            });

            // Highlight the sorted column
            const urlParams = new URLSearchParams(window.location.search);
            const sortedColumn = urlParams.get('sort');
            const sortedOrder = urlParams.get('order');
            if (sortedColumn && sortedOrder) {
                const th = document.querySelector(`th[data-column='${sortedColumn}']`);
                if (th) {
                    th.classList.add(`sorted-${sortedOrder}`);
                }
            }
        });
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
                </div>
                <div class="table-container">
                    <table id="table_booklist">
                        <thead>
                            <tr>
                                <th data-column="title">Title <i class="fa-solid fa-sort"></i></th>
                                <th data-column="author">Author <i class="fa-solid fa-sort"></i></th>
                                <th data-column="isbn">ISBN <i class="fa-solid fa-sort"></i></th>
                                <th data-column="genre">Genre <i class="fa-solid fa-sort"></i></th>
                                <th data-column="copies">Copies <i class="fa-solid fa-sort"></i></th>
                                <th data-column="available_copies">Status <i class="fa-solid fa-sort"></i></th>
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
    <div class="sidebar"> <!-- adding sidebar, buttons and links -->
        <div class="buttons">
            <button class="button_house"id="button_houseID"onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-house" style="color: #0f0f0f;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_equals"onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_booklist"id="button_booklistID"onclick="window.location.href='fe_booklist.php'">
                <i class="fa-solid fa-book-bookmark" style="color: #030303;"></i> <!-- adding fontawesome icon -->
            </button> 
            <button class="button_memberlist"id="button_memberlistID"onclick="window.location.href='fe_memberlist.php'">
                <i class="fa-solid fa-users" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_overduebooks"id="button_overduebooksID"onclick="window.location.href='fe_overduebooks.php'">
                <i class="fa-solid fa-triangle-exclamation" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_loans"id="button_loansID"onclick="window.location.href='fe_loans.php'">
                <i class="fa-solid fa-right-long"></i> <!-- adding fontawesome icon -->
            </button>
            <button class="button_settings">
                <i class="fa-solid fa-gear" style="color: #000000;"></i> <!-- adding fontawesome icon -->
            </button>
        </div>
    </div>
    <div class="menu" id="menu"> <!-- adding menu with bullet points -->
        <ul>
            <li><a href="#" id="Dashboard"onclick="window.location.href='dashboard.php'">Dashboard</a></li>
            <li><a href="#" id="Booklist"onclick="window.location.href='fe_booklist.php'">Books</a></li>
            <li><a href="#" id="Memberlist"onclick="window.location.href='fe_memberlist.php'">Members</a></li>
            <li><a href="#" id="overduebooks"onclick="window.location.href='fe_overduebooks.php'">Overdue</a></li>
            <li><a href="#" id="Loans"onclick="window.location.href='fe_loans.php'">Loans</a></li>
        </ul>
    </div>
</body>
</html>
