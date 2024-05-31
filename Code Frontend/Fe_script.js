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
if (sidebar.classList.contains("active")) {
    whiteSquare.style.left = '850px'; //
    whiteSquare.style.width = 'calc(1700px - 130px - 44px)';
    whiteSquare.style.transition = 'width 0.6s';
} else {
    whiteSquare.style.left = '50%';
    whiteSquare.style.transform = 'translateX(-50%)';
    whiteSquare.style.width = '1650px';
    whiteSquare.style.transition = 'width 0.6s';
}
}

// function hover_Dashboard 
function function_hover_dashboard() {
    var dashboardItem = document.getElementById("Dashboard");
    var buttonHouseIcon = document.getElementById("button_houseID");

    // Function to change size
    function changeSize() {
        // Change font size of Dashboard text
        dashboardItem.style.fontSize = "20px";

        // Enlarge the icon
        buttonHouseIcon.style.transform = "scale(1.1)";
    }

    // Function to reset size
    function resetSize() {
        // Reset font size of Dashboard text
        dashboardItem.style.fontSize = "16px";

        // Reset icon size
        buttonHouseIcon.style.transform = "scale(1)";
    }

    // Event listener for mouseenter event on Dashboard element
    dashboardItem.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on Dashboard element
    dashboardItem.addEventListener("mouseleave", resetSize);

    // Event listener for mouseenter event on the icon
    buttonHouseIcon.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on the icon
    buttonHouseIcon.addEventListener("mouseleave", resetSize);

    // Event listener for click event on the Dashboard element
    dashboardItem.addEventListener("click", changeSize);

    // Event listener for click event on the icon
    buttonHouseIcon.addEventListener("click", changeSize);
}

// Call the function when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    function_hover_dashboard();
});


// function hover_booklist 
function function_hover_booklist() {
    var booklistItem = document.getElementById("Booklist");
    var buttonBooklistIcon = document.getElementById("button_booklistID");

    // Function to change size
    function changeSize() {
        // Change font size of Booklist text
        booklistItem.style.fontSize = "20px";

        // Enlarge the icon
        buttonBooklistIcon.style.transform = "scale(1.1)";
    }

    // Function to reset size
    function resetSize() {
        // Reset font size of Booklist text
        booklistItem.style.fontSize = "16px";

        // Reset icon size
        buttonBooklistIcon.style.transform = "scale(1)";
    }

    // Event listener for mouseenter event on Booklist element
    booklistItem.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on Booklist element
    booklistItem.addEventListener("mouseleave", resetSize);

    // Event listener for mouseenter event on the icon
    buttonBooklistIcon.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on the icon
    buttonBooklistIcon.addEventListener("mouseleave", resetSize);

    // Event listener for click event on the Booklist element
    booklistItem.addEventListener("click", changeSize);

    // Event listener for click event on the icon
    buttonBooklistIcon.addEventListener("click", changeSize);
}

// Call the function when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    function_hover_booklist();
});


// function hover_memberlist 
function function_hover_memberlist() {
    var memberlistItem = document.getElementById("Memberlist");
    var buttonMemberlistIcon = document.getElementById("button_memberlistID");

    // Function to change size
    function changeSize() {
        // Change font size of Memberlist text
        memberlistItem.style.fontSize = "20px";

        // Enlarge the icon
        buttonMemberlistIcon.style.transform = "scale(1.1)";
    }

    // Function to reset size
    function resetSize() {
        // Reset font size of Memberlist text
        memberlistItem.style.fontSize = "16px";

        // Reset icon size
        buttonMemberlistIcon.style.transform = "scale(1)";
    }

    // Event listener for mouseenter event on Memberlist element
    memberlistItem.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on Memberlist element
    memberlistItem.addEventListener("mouseleave", resetSize);

    // Event listener for mouseenter event on the icon
    buttonMemberlistIcon.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on the icon
    buttonMemberlistIcon.addEventListener("mouseleave", resetSize);

    // Event listener for click event on the Memberlist element
    memberlistItem.addEventListener("click", changeSize);

    // Event listener for click event on the icon
    buttonMemberlistIcon.addEventListener("click", changeSize);
}

// Call the function when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    function_hover_memberlist();
});


// function hover_reminder
function function_hover_reminder() {
    var reminderItem = document.getElementById("Reminder");
    var buttonReminderIcon = document.getElementById("button_reminderID");

    // Function to change size
    function changeSize() {
        // Change font size of Reminder text
        reminderItem.style.fontSize = "20px";

        // Enlarge the icon
        buttonReminderIcon.style.transform = "scale(1.1)";
    }

    // Function to reset size
    function resetSize() {
        // Reset font size of Reminder text
        reminderItem.style.fontSize = "16px";

        // Reset icon size
        buttonReminderIcon.style.transform = "scale(1)";
    }

    // Event listener for mouseenter event on Reminder element
    reminderItem.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on Reminder element
    reminderItem.addEventListener("mouseleave", resetSize);

    // Event listener for mouseenter event on the icon
    buttonReminderIcon.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on the icon
    buttonReminderIcon.addEventListener("mouseleave", resetSize);

    // Event listener for click event on the Reminder element
    reminderItem.addEventListener("click", changeSize);

    // Event listener for click event on the icon
    buttonReminderIcon.addEventListener("click", changeSize);
}

// Call the function when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    function_hover_reminder();
});


// function hover_loans
function function_hover_loans() {
    var loansItem = document.getElementById("Loans");
    var buttonLoansIcon = document.getElementById("button_loansID");

    // Function to change size
    function changeSize() {
        // Change font size of Loans text
        loansItem.style.fontSize = "20px";

        // Enlarge the icon
        buttonLoansIcon.style.transform = "scale(1.1)";
    }

    // Function to reset size
    function resetSize() {
        // Reset font size of Loans text
        loansItem.style.fontSize = "16px";

        // Reset icon size
        buttonLoansIcon.style.transform = "scale(1)";
    }

    // Event listener for mouseenter event on Loans element
    loansItem.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on Loans element
    loansItem.addEventListener("mouseleave", resetSize);

    // Event listener for mouseenter event on the icon
    buttonLoansIcon.addEventListener("mouseenter", changeSize);

    // Event listener for mouseleave event on the icon
    buttonLoansIcon.addEventListener("mouseleave", resetSize);

    // Event listener for click event on the Loans element
    loansItem.addEventListener("click", changeSize);

    // Event listener for click event on the icon
    buttonLoansIcon.addEventListener("click", changeSize);
}

// Call the function when the document is loaded
document.addEventListener("DOMContentLoaded", function() {
    function_hover_loans();
});

// function tableRows
document.addEventListener('DOMContentLoaded', function() {
    // Get all table rows except the header row
    const tableRows = document.querySelectorAll('.table-row');
        
    // Add event listener to each table row
    tableRows.forEach(row => {
        row.addEventListener('mouseover', function() {
            // Get the row number
            const rowNumber = this.dataset.rowNumber;
            // Exclude the first row
            if (rowNumber !== '1') {
                // Redirect to another HTML page
                 window.location.href = 'other_page.html';
            }
        });
    });
});