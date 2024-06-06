<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="LibroFact" content="Library of Books">
    <title>Neues Buch hinzufügen - LibrioFact</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        .background {
            background-color: #404040;
            height: 100vh;
            display: flex;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            box-sizing: border-box;
        }

        .scrollable-content {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #888888;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
        }

        .logo {
            z-index: 1000;
        }

        .logo_name {
            font-size: 13px;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            color: rgb(0, 0, 0);
            font-weight: bold;
            position: absolute;
            top: 25px;
            left: 120px;
            z-index: 1001;
        }

        .logo_pic {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: auto;
            background-image: url('Pfad/zum/deinem/Bild/logo_pic.png');
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 1000;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 75px;
            height: 100%;
            background-color: #888888;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }

        .button_equals,
        .button_house,
        .button_booklist,
        .button_memberlist,
        .button_reminder,
        .button_loans,
        .button_settings {
            background-size: cover;
            background-color: #888888;
            background-position: center;
            background-repeat: no-repeat;
            width: 35px;
            height: 35px;
            margin-top: 20px;
            display: block;
            border: none;
            cursor: pointer;
        }

        .button_equals {
            background-image: url('button_equals.png');
            margin-top: 30px;
        }

        .button_house {
            background-image: url('button_house.png');
        }

        .button_booklist {
            background-image: url('button_booklist.png');
        }

        .button_memberlist {
            background-image: url('button_memberlist.png');
        }

        .button_reminder {
            background-image: url('button_reminder.png');
        }

        .button_loans {
            background-image: url('button_loans.png');
        }

        .button_settings {
            background-image: url('button_settings.png');
            position: absolute;
            bottom: 30px;
            left: 15px;
        }

        .button_profile {
            position: fixed;
            top: 0px;
            right: 20px;
            padding: 10px 40px;
            border: none;
            border-radius: 20px;
            background-color: #acacac;
            color: #000000;
            cursor: pointer;
            z-index: 999;
            transition: all 0.3s;
        }

        .button_profile:hover {
            transform: scale(1.06);
        }

        .button:hover {
            transform: scale(1.1);
        }

        .sidebar.active {
            width: calc(35px + 150px);
        }

        .menu {
            position: fixed;
            top: 30px;
            left: 70px;
            width: 150px;
            background-color: #888888;
            z-index: 999;
            display: none;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
        }

        .menu ul li {
            padding: 10px;
            margin-bottom: -20px;
        }

        .menu ul li a {
            color: #000000;
            text-decoration: none;
            display: block;
            padding-top: 44px;
        }

        .menu.active {
            display: block;
        }

        .form-container {
            width: 90%;
            background-color: #ffffff;
            border-radius: 10px;
            margin-left: auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 100px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 1.2em;
            margin: 10px 0 5px 0;
        }

        input {
            padding: 10px;
            margin-bottom: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            background-color: #888888;
            color: #ffffff;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #555555;
        }

        .book-entry {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            position: relative;
        }

        .remove-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff6666;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            color: #ffffff;
            font-size: 1em;
            line-height: 25px;
            text-align: center;
        }

    </style>
    <script>
        function addBookEntry() {
            const container = document.getElementById('books-container');
            const bookEntry = document.createElement('div');
            bookEntry.className = 'book-entry';
            bookEntry.innerHTML = `

                        <div style="display: flex; flex-direction: column; align-items: center;">
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label for="isbn">ISBN:</label>
                    <input type="text" name="isbn" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label for="author">Autor:</label>
                    <input type="text" name="author" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label for="genre">Genre:</label>
                    <input type="text" name="genre" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label for="title">Titel:</label>
                    <input type="text" name="title" required>
                </div>
            </div>
            <button onclick="removeBookEntry(this)" style="margin-top: 10px;">Remove Book</button>
            `;
            container.appendChild(bookEntry);
        }

        function removeBookEntry(button) {
            const container = document.getElementById('books-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            } else {
                alert('There has to be at least one Book entry.');
            }
        }

        function toggleMenu() {
            document.getElementById('menu').classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            addBookEntry();
        });
    </script>
</head>
<body>
    <div class="topbar">
        <div class="logo_name" onclick="window.location.href='fe_Libriofact.html'">LibrioFact</div>
        <button class="button_profile" onclick="window.location.href='fe_profile.html'">Admin</button>
        <div class="logo_pic"></div>
    </div>
    <div class="sidebar">
        <button class="button_equals" onclick="toggleMenu()"></button>
        <button class="button_house" id="button_houseID" onclick="window.location.href='fe_dashboard.html'"></button>
        <button class="button_booklist" id="button_booklistID" onclick="window.location.href='fe_booklist.html'"></button>
        <button class="button_memberlist" id="button_memberlistID" onclick="window.location.href='fe_memberlist.html'"></button>
        <button class="button_reminder" id="button_reminderID" onclick="window.location.href='fe_reminder.html'"></button>
        <button class="button_loans" id="button_loansID" onclick="window.location.href='fe_loans.html'"></button>
        <button class="button_settings" onclick="window.location.href='fe_settings.html'"></button>
    </div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="#" id="Dashboard" onclick="window.location.href='fe_dashboard.html'">Dashboard</a></li>
            <li><a href="#" id="Booklist" onclick="window.location.href='fe_booklist.html'">Books</a></li>
            <li><a href="#" id="Memberlist" onclick="window.location.href='fe_memberlist.html'">Members</a></li>
            <li><a href="#" id="Reminder" onclick="window.location.href='fe_loans.html'">Reminder</a></li>
            <li><a href="#" id="Loans" onclick="window.location.href='fe_settings.html'">Loans</a></li>
        </ul>
    </div>
    <div class="background">
        <div class="scrollable-content">
            <div class="form-container">
                <h2>Add new Book(s)</h2>
                <form id="books-form">
                    <div id="books-container"></div>
                    <button type="button" onclick="addBookEntry()">Add another new Book</button>
                    <button type="submit">Add Book(s)</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>