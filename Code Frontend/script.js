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

// Event Listener if the document is loaded
document.addEventListener('DOMContentLoaded', function() {
    adjustTableHeight(); // Initial Hight Adjustment

    // Event Listener for resizing 
    window.addEventListener('resize', adjustTableHeight);
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

// Event listener clickable rows in the member list table and redirection to member details after klicking in one row
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.clickable-row'); // choose all lines with clickable-row
    rows.forEach(row => {
        row.addEventListener('click', function() {
            const memberId = this.dataset.memberId; // get ID from a line
            window.location.href = `member_details.php?member_id=${memberId}`; // redirekting
        });
    });
});




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


        
        // adding new field for books if a book is loaned or returned
        function addBookField() {
            const container = document.getElementById('bookFieldsContainer');
            const messageContainer = document.getElementById('messageContainer');

            if (container.children.length < 10) {
                const index = container.children.length + 1;
                const newField = document.createElement('div');
                newField.className = 'form-group-addbook book-field';
                newField.innerHTML = `
                    <label for="book_id_${index}">Book-ID</label>
                    <input type="text" id="book_id_${index}" name="book_id[]">
                `;
                container.appendChild(newField);
                messageContainer.textContent = ''; // Clear any previous message
                messageContainer.style.display = 'none'; // Hide the message container
            } else {
                messageContainer.textContent = "You can only add up to 10 books at a time.";
                messageContainer.style.display = 'block'; // Show the message container
            }
        }
        

        function removeBookField() {
            const container = document.getElementById('bookFieldsContainer');
            const messageContainer = document.getElementById('messageContainer');
        
            if (container.children.length > 1) {
                container.removeChild(container.lastChild);
                messageContainer.textContent = ''; // Clear the message
                messageContainer.style.display = 'none'; // Hide the message container
            }
        }



        function adjustTableContainerHeight() {
            const tableContainer = document.querySelector('.table-container');
            const windowHeight = window.innerHeight;
            const containerHeight = windowHeight * 0.6; // 60% of hight of the window
            tableContainer.style.maxHeight = containerHeight + 'px';
        }

        window.addEventListener('resize', adjustTableContainerHeight);
        window.addEventListener('load', adjustTableContainerHeight); // initial load changes the hight
        document.addEventListener('DOMContentLoaded', adjustTableContainerHeight); // Hif dom is loaded hight is adjusted

    