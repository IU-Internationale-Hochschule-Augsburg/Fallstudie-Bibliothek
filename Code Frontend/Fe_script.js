// menu function, very important!
function toggleMenu() {
    var menu = document.getElementById("menu");
    menu.classList.toggle("active");

// sidebar function
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("active");

// background function
var background = document.querySelector(".background");
if (sidebar.classList.contains("active")) {
    background.style.left = '210px';
    background.style.width = 'calc(100% - 210px)';
} else {
    background.style.left = '75px';
    background.style.width = 'calc(100% - 75px)';
}


    // White Square function
    var whiteSquare = document.getElementById("white-squareID");
    whiteSquare.style.width = '90%';  
    whiteSquare.style.height = '80%'; 
    whiteSquare.style.top = '100px';
    whiteSquare.style.left = '50%';
    whiteSquare.style.transform = 'translateX(-50%)';
    whiteSquare.style.transition = 'width 0.6s, height 0.6s';
}

// Layout_sort function and layout 
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let resultsPerPage = 14;
    let activeSortButton = 'layer_sortID'; // Initial active sort button

    // Function to update resultsPerPage based on active sort button and available books
    function updateResultsPerPage() {
        const whiteSquareSize = 15; // Assume white square size, adjust as necessary
        const availableBooks = books.length;

        if (activeSortButton === 'layer_sortID') {
            resultsPerPage = Math.min(whiteSquareSize - 1, availableBooks); // Adjusted to be two less than whiteSquareSize
        } else {
            resultsPerPage = availableBooks;
        }
    }

    // Function to handle color change and active state toggle for sort buttons
    function toggleSortButtons(buttonId) {
        const activeButton = document.getElementById(buttonId);
        const inactiveButtonId = buttonId === 'layer_sortID' ? 'vertical_sortID' : 'layer_sortID';
        const inactiveButton = document.getElementById(inactiveButtonId);

        activeButton.querySelector('i').style.color = '#494969'; // Make active button gray
        inactiveButton.querySelector('i').style.color = '#656567'; // Make inactive button blue

        activeSortButton = buttonId; // Update active sort button
    }

    // Initial setup: layer_sort is active by default
    toggleSortButtons(activeSortButton);

    // Event listener for layer_sort button
    document.getElementById('layer_sortID').addEventListener('click', function() {
        if (activeSortButton !== 'layer_sortID') {
            toggleSortButtons('layer_sortID');
            currentPage = 1; // Reset to first page
            updateResultsPerPage();
            displayBooks();
        }
    });

    // Event listener for vertical_sort button
    document.getElementById('vertical_sortID').addEventListener('click', function() {
        if (activeSortButton !== 'vertical_sortID') {
            toggleSortButtons('vertical_sortID');
            currentPage = 1; // Reset to first page
            updateResultsPerPage();
            displayBooks();
        }
    });

    // Function to display books based on currentPage and resultsPerPage
    function displayBooks() {
        const start = (currentPage - 1) * resultsPerPage;
        const end = start + resultsPerPage;
        const paginatedBooks = books.slice(start, end);

        const tableBody = document.querySelector("#table_booklist tbody");
        tableBody.innerHTML = "";

        paginatedBooks.forEach(book => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${book.title}</td>
                <td>${book.author}</td>
                <td>${book.isbn}</td>
                <td>${book.genre}</td>
                <td>${book.copies}</td>
                <td>${book.available_copies === 0 ? "All Copies on Loan" : `${book.available_copies} ${book.available_copies === 1 ? "Copy available" : "Copies available"}`}</td>
                <td>
                    <a href="book_edit.php?isbn=${book.isbn}">Edit</a> |
                    <a href="book_copies.php?isbn=${book.isbn}">View Copies</a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        updatePaginationButtons();

        // Dynamic adjustment of table height based on the height of the White Square
        const whiteSquareHeight = document.querySelector('.white-square').clientHeight;
        const tableContainer = document.querySelector("#table_booklist-container");
        const desiredTableHeight = whiteSquareHeight - 30; // 30px spacing (15px top + 15px bottom)

        tableContainer.style.maxHeight = `${desiredTableHeight}px`;
    }

    // Function to update pagination buttons based on currentPage and resultsPerPage
    function updatePaginationButtons() {
        const previousButton = document.querySelector(".button_previous");
        const nextButton = document.querySelector(".button_next");

        previousButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === Math.ceil(books.length / resultsPerPage);
    }

    // Function to navigate to previous page
    window.previousPage = function() {
        if (currentPage > 1) {
            currentPage--;
            displayBooks();
        }
    };

    // Function to navigate to next page
    window.nextPage = function() {
        if (currentPage < Math.ceil(books.length / resultsPerPage)) {
            currentPage++;
            displayBooks();
        }
    };

    // Initial display of books
    displayBooks();
});

// Funktion zur Anpassung der Tabellenhöhe basierend auf der White Square Höhe
function adjustTableHeight() {
    var whiteSquare = document.querySelector('.white-square');
    var tableContainer = document.getElementById('table_booklist-container');
    var whiteSquareHeight = whiteSquare.clientHeight;
    var desiredTableHeight = whiteSquareHeight - 30; // 30px Abstand (15px oben + 15px unten)

    tableContainer.style.maxHeight = desiredTableHeight + 'px';
}

// Event Listener beim Laden der Seite hinzufügen
document.addEventListener('DOMContentLoaded', function() {
    adjustTableHeight(); // Initial aufrufen

    // Event Listener für Resize-Events (falls das White Square sich ändert)
    window.addEventListener('resize', adjustTableHeight);
});






// Add function move buttons
function checkAndMoveButtons() {
    // Get the "vertical layer" button
    var verticalLayerButton = document.getElementById('verticalLayerButton');
    
    // Check if the "vertical layer" button has the color #494969
    if (window.getComputedStyle(verticalLayerButton).backgroundColor === 'rgb(73, 73, 105)') {
        // Get the "previous" and "next" buttons
        var previousButton = document.getElementById('previousButton');
        var nextButton = document.getElementById('nextButton');
        
        // Shift the buttons 300px to the right
        previousButton.style.transform = 'translateX(300px)';
        nextButton.style.transform = 'translateX(300px)';
    }
}

// Execute the function when the page loads
window.onload = checkAndMoveButtons;

// Add event listener for when the state of the button changes
document.getElementById('verticalLayerButton').addEventListener('click', checkAndMoveButtons);




// Execute the function when the page loads
window.onload = checkAndMoveButtons;

// Add event listener for when the state of the button changes
document.getElementById('verticalLayerButton').addEventListener('click', checkAndMoveButtons);








// General function for hover effects
function setupHoverEffect(itemId, iconId) {
    var item = document.getElementById(itemId);
    var icon = document.getElementById(iconId);

    function changeSize() {
        item.style.fontSize = "20px";
        icon.style.transform = "scale(1.1)";
    }

    function resetSize() {
        item.style.fontSize = "16px";
        icon.style.transform = "scale(1)";
    }

    item.addEventListener("mouseenter", changeSize);
    item.addEventListener("mouseleave", resetSize);
    icon.addEventListener("mouseenter", changeSize);
    icon.addEventListener("mouseleave", resetSize);
    item.addEventListener("click", changeSize);
    icon.addEventListener("click", changeSize);
}

// Call the function for hover effects once the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    setupHoverEffect("Dashboard", "button_houseID");
    setupHoverEffect("Booklist", "button_booklistID");
    setupHoverEffect("Memberlist", "button_memberlistID");
    setupHoverEffect("overduebooks", "button_overduebooksID");
    setupHoverEffect("Loans", "button_loansID");
});

// Event listener for clicking on rows in the table
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
    const rows = document.querySelectorAll('#table_booklist tr[data-href]');
    console.log("Number of rows found: ", rows.length);
    rows.forEach(row => {
        console.log("Row found: ", row);
        row.addEventListener('click', function() {
            console.log("Row clicked: ", this.dataset.href);
            window.location.href = this.dataset.href;
        });
    });
});

// Event listener for clicking on rows in the member list table
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#table_memberlist tr:not(:first-child)');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
    });
});