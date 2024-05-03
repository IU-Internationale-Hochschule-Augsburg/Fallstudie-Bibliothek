<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meine_bibliothek";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen:  " . $conn->connect_error);
}
^


// SQL-Abfrage, um Daten aus der Tabelle 'buecher' zu holen
$sql = "SELECT titel, autor FROM buecher";
$result = $conn->query($sql);

                        // Überprüft, ob die Abfrage mehr als 0 Zeilen zurückgegeben hat
if ($result->num_rows > 0) {
    // Beginnt eine HTML-Tabelle mit einer Rahmenbreite von 1 zu erstellen
    echo "<table border='1'><tr><th>Titel</th><th>Autor</th></tr>";
    // Schleife, die für jede Zeile der Ergebnisse durchlaufen wird
    while($row = $result->fetch_assoc()) {
        // Erstellt eine Tabellenzeile für jedes Buch mit Titel und Autor
        echo "<tr><td>" . $row["titel"] . "</td><td>" . $row["autor"] . "</td></tr>";
    }
    // Beendet die HTML-Tabelle
    echo "</table>";
} else {
                        // Gibt einen Text aus, wenn keine Ergebnisse gefunden wurden
    echo "0 Ergebnisse";
}
$conn->close();
?>
