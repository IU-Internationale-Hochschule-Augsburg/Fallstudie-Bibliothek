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
    whiteSquare.style.width = '90%';  // Adjust the width as a percentage
    whiteSquare.style.height = '80%'; // Adjust the height as a percentage
    whiteSquare.style.top = '100px';
    whiteSquare.style.left = '50%';
    whiteSquare.style.transform = 'translateX(-50%)';
    whiteSquare.style.transition = 'width 0.6s, height 0.6s';
}

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

