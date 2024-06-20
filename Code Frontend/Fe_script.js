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

// changeIconColorfunction for sort buttons
function changeIconColor(buttonId) {
    var icon = document.querySelector(`#${buttonId} i`);
    var isGray = icon.style.color === 'rgb(101, 101, 103)' || icon.style.color === 'rgb(101,101,103)' || icon.style.color === '';

    if (isGray) {
        icon.style.color = '#494969';
    } else {
        icon.style.color = '#656567';
    }
}

// DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    var layerSortButton = document.getElementById('layer_sortID');
    var verticalSortButton = document.getElementById('vertical_sortID');
    
    // Initial selection: layer_sort is active by default
    layerSortButton.classList.add('active');
    changeIconColor('layer_sortID');

    // Function to toggle active state and colors
    function toggleButton(button) {
        if (!button.classList.contains('active')) {
            button.classList.add('active');
            changeIconColor(button.id);
        }
    }

    // Event listener for layer_sort button
    layerSortButton.addEventListener('click', function() {
        if (!layerSortButton.classList.contains('active')) {
            toggleButton(layerSortButton); // Toggle active state
            verticalSortButton.classList.remove('active'); // Remove active from vertical_sort
            changeIconColor('vertical_sortID'); // Reset color of vertical_sort button
        }
    });

    // Event listener for vertical_sort button
    verticalSortButton.addEventListener('click', function() {
        if (!verticalSortButton.classList.contains('active')) {
            toggleButton(verticalSortButton); // Toggle active state
            layerSortButton.classList.remove('active'); // Remove active from layer_sort
            changeIconColor('layer_sortID'); // Reset color of layer_sort button
        }
    });
});

// function for button layer_sort
document.addEventListener("DOMContentLoaded", function() {
    let currentPage = 1;
    let resultsPerPage = 15;

    function changeIconColor(buttonId) {
        var icon = document.querySelector(`#${buttonId} i`);
        var isGray = icon.style.color === 'rgb(101, 101, 103)' || icon.style.color === 'rgb(101,101,103)' || icon.style.color === '';

        if (isGray) {
            icon.style.color = '#494969';
        } else {
            icon.style.color = '#656567';
        }

        // Check if layer_sort button has the specific color
        var layerSortButton = document.getElementById('layer_sortID');
        var layerSortIcon = layerSortButton.querySelector('i');
        resultsPerPage = (layerSortIcon.style.color === 'rgb(101, 101, 103)' || layerSortIcon.style.color === 'rgb(101,101,103)' || layerSortIcon.style.color === '') ? 15 : books.length;
        currentPage = 1; // Reset to first page
        displayBooks();
    }

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
                <td>${book.available_copies == 0 ? "All Copies on Loan" : book.available_copies + (book.available_copies == 1 ? " Copy available " : " Copies available ")}</td>
                <td>
                    <a href="book_edit.php?isbn=${book.isbn}">Edit </a> |
                    <a href="book_copies.php?isbn=${book.isbn}">View Copies</a>
                </td>
            `;

            tableBody.appendChild(row);
        });

        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        const previousButton = document.querySelector(".button_previous");
        const nextButton = document.querySelector(".button_next");

        previousButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === Math.ceil(books.length / resultsPerPage);
    }

    window.previousPage = function() {
        if (currentPage > 1) {
            currentPage--;
            displayBooks();
        }
    };

    window.nextPage = function() {
        if (currentPage < Math.ceil(books.length / resultsPerPage)) {
            currentPage++;
            displayBooks();
        }
    };

    window.changeIconColor = changeIconColor;

    // Initial display
    displayBooks();
});









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

// Call the function once the document is loaded
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

// function not first child
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#table_memberlist tr:not(:first-child)');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#table_booklist tr[data-href]');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
    });
});

