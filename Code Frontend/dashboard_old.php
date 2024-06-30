<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="LibroFact" content="Library of Books">
<title>Startseite für die Bibliothekssoftware</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Allgemeine Stildefinitionen */
        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #404040;
        }
        /* Stil für den Kopfbereich */
        header {
            background-color:#888888;
            height: 100px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Stil für die Suchleiste */
        .search-bar {
            height: 50px;
            width: 30%;
            padding: 5px 10px;
            border: none;
            outline: none;
            font-size: 16px;
            background-color: white;
            color: black;
            border-radius: 15px;
        }
        /* Stil für das Glockensymbol */
        .bell-icon {
            font-size: 35px;
            color: white;
            margin-left: 20px;
        }
        /* Stil für den seitlichen Bereich */
        aside {
            background-color:#888888;
            width: 100px;
            height: calc(100% - 50px);
            position: absolute;
            top: 50px;
            left: 0;
        }
        /* Stil für den Hauptteil der Seite */
        main {
            margin-left: 200px;
            padding: 20px;
            color: white;
        }
        /* Stil für die Statistiken */
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        /* Stil für einzelne Statistiken */
        .stat {
        flex: 1; /* Alle Statistiken nehmen den gleichen Anteil am verfügbaren Raum ein */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: grey;
        height: 150px; /* Ändere diesen Wert entsprechend deinen Anforderungen */
        padding: 10px;
        margin: 0 20px;
        border-radius: 10px;
        text-align: center;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

        /* Stil für Inhalte innerhalb einer Statistik */
        .content {
            display: flex;
            align-items: center;
        }
        /* Stil für Symbole innerhalb einer Statistik */
        .icons {
            display: flex;
        }
        /* Stil für Überschriften und Symbole innerhalb des Inhalts */
        .content h2, .content i {
            margin-right: 5px;
        }
        /* Stil für Text innerhalb einer Statistik */
        .stat p {
            margin-top: 5px;
            font-size: 22px;
            font-weight: bold;
        }
        /* Stil für Symbole innerhalb einer Statistik */
        .icons i {
            margin-left: 5px;
        }
        /* Stil für Symbole in Statistiken */
        .stat i {
            font-size: 24px;
            color: white;
        }
        /* Stil für Überschriften in Statistiken */
        .stat h2 {
            margin-bottom: 5px;
            font-size: 25px;
        }
        /* Stil für Zahlen in Statistiken */
        .stat p {
            font-size: 40px;
            font-weight: bold;
        }
        /* Stil für allgemeinen Text */
        h1, p {
            color: white;
        }
        /* Stil für die Nutzerliste und Bücherliste */
        .user-list, .book-list, .overdue-list, .issued-list {
            margin-top: 20px;
            background-color: grey;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        /* Stil für Überschriften der Listen */
        .user-list h2, .book-list h2, .overdue-list h2, .issued-list h2 {
            font-size: 25px;
            margin-bottom: 10px;
        }
        /* Stil für die Nutzerliste-Tabelle */
        .user-list table, .book-list table, .overdue-list table, .issued-list table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Automatische Anpassung der Spaltenbreite */
        }
        /* Stil für Tabellenüberschriften */
        .user-list th, .book-list th, .overdue-list th, .issued-list th {
            background-color: #333;
            color: white;
            padding: 10px;
            border: 1px solid #555;
            text-align: center;
        }
        /* Stil für Tabellenzellen */
        .user-list td, .book-list td, .overdue-list td, .issued-list td {
            background-color: #555;
            color: white;
            padding: 10px;
            border: 1px solid #333;
            text-align: center;
        }
    </style>    
</head>
<body>
    <!-- Der Kopfbereich der Seite -->
    <header>
        <!-- Eingabefeld für die Suche -->
        <input type="search" class="search-bar" placeholder="Suche...">
        <!-- Glockenikone für Benachrichtigungen -->
        <span class="bell-icon">🔔</span>
    </header>
    <!-- Leerer Bereich an der Seite -->
    <aside></aside>
    <!-- Hauptteil der Seite -->
    <main>
        <!-- Begrüßung und Anzeige des Datums -->
        <h1>Hallo XY<br>Aktuelles Datum || heutiger Tag</h1>
        <!-- Statistiken über Besucher, Bücher usw. -->
        <div class="stats">
            <!-- Statistik über alle Besucher -->
            <div class="stat">
                <!-- Überschrift "Alle Besucher" und Bild von Menschen -->
                <div class="content">
                    <h2>Alle Besucher</h2>
                    <i class="fas fa-users"></i>
                </div>
                <!-- Anzahl der Besucher -->
                <p>123</p>
            </div>
            <!-- Statistik über ausgeliehene Bücher -->
            <div class="stat">
                <!-- Überschrift "Ausgeliehene Bücher" und Bilder von Büchern und Uhren -->
                <div class="content">
                    <h2>Ausgeliehene Bücher</h2>
                    <br>
                    <div class="icons">
                        <i class="fas fa-book"></i>
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <!-- Anzahl der ausgeliehenen Bücher -->
                <p>456</p>
            </div>
            <!-- Statistik über überfällige Bücher -->
            <div class="stat">
                <!-- Überschrift "Überfällige Bücher" und Bild einer Sanduhr -->
                <div class="content">
                    <h2>Überfällige Bücher</h2>
                    <i class="fas fa-hourglass-end"></i>
                </div>
                <!-- Anzahl der überfälligen Bücher -->
                <p>78</p>
            </div>
            <!-- Statistik über neue Mitglieder -->
            <div class="stat">
                <!-- Überschrift "Neue Mitglieder" und Bild eines Pluszeichens -->
                <div class="content">
                    <h2>Neue Mitglieder</h2>
                    <i class="fas fa-user-plus"></i>
                </div>
                <!-- Anzahl der neuen Mitglieder -->
                <p>90</p>
            </div>
        </div>
        <!-- Nutzerliste -->
        <div class="user-list">
            <h2>Nutzerliste</h2>
            <!-- Tabelle für die Nutzerliste -->
            <table>
                <!-- Tabellenkopf -->
                <thead>
                    <tr>
                        <th>User-ID</th>
                        <th>Name</th>
                        <th>Ausgeliehene Bücher</th>
                    </tr>
                </thead>
                <!-- Tabelleninhalt -->
                <tbody>
                    <!-- Beispielzeile für einen Nutzer -->
                    <tr>
                        <td>1</td>
                        <td>Max Mustermann</td>
                        <td>Harry Potter und der Stein der Weisen, Der Herr der Ringe</td>
                    </tr>
                    <!-- Weitere Nutzerzeilen hier einfügen -->
                </tbody>
            </table>
        </div>
        <!-- Bücherliste -->
        <div class="book-list">
            <h2>Bücherliste</h2>
            <!-- Tabelle für die Bücherliste -->
            <table>
                <!-- Tabellenkopf -->
                <thead>
                    <tr>
                        <th>Autorname</th>
                        <th>Name des Buches</th>
                        <th>ISBN</th>
                        <th>Verfügbarkeit</th>
                    </tr>
                </thead>
                <!-- Tabelleninhalt -->
                <tbody>
                    <!-- Beispielzeile für ein Buch -->
                    <tr>
                        <td>J.K. Rowling</td>
                        <td>Harry Potter und der Stein der Weisen</td>
                        <td>978-3-551-51103-9</td>
                        <td>Verfügbar</td>
                    </tr>
                    <!-- Weitere Buchzeilen hier einfügen -->
                </tbody>
            </table>
        </div>
        <!-- Überfällige Bücher -->
        <div class="overdue-list">
            <h2>Überfällige Bücher</h2>
            <!-- Tabelle für überfällige Bücher -->
            <table>
                <!-- Tabellenkopf -->
                <thead>
                    <tr>
                        <th>User-ID</th>
                        <th>User Name</th>
                        <th>ISBN</th>
                        <th>Buchtitel</th>
                        <th>Autor Name</th>
                        <th>überfälliges Buch</th>
                        <th>Status</th>
                        <th>Geldstrafe</th>
                    </tr>
                </thead>
                <!-- Tabelleninhalt -->
                <tbody>
                    <!-- Beispielzeile für ein überfälliges Buch -->
                    <tr>
                        <td>123456</td>
                        <td>Angelo</td>
                        <td>987654</td>
                        <td>The Great Divorce</td>
                        <td>C.S.Lewis</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                    <!-- Weitere überfällige Buchzeilen hier einfügen -->
                </tbody>
            </table>
        </div>
        <!-- Ausgegebene Bücher -->
        <div class="issued-list">
            <h2>Ausgegebene Bücher</h2>
            <!-- Tabelle für ausgegebene Bücher -->
            <table>
                <!-- Tabellenkopf -->
                <thead>
                    <tr>
                        <th>User-ID</th>
                        <th>Buchtitel</th>
                        <th>Ausgabedatum</th>
                        <th>Rückgabedatum</th>
                    </tr>
                </thead>
                <!-- Tabelleninhalt -->
                <tbody>
                    <!-- Beispielzeile für ein ausgegebenes Buch -->
                    <tr>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                    <!-- Weitere ausgegebene Buchzeilen hier einfügen -->
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
