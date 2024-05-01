<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meine_bibliothek";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage, um Daten aus der Tabelle 'buecher' zu holen
$sql = "SELECT titel, autor FROM buecher";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Tabelle Kopf
    echo "<table border='1'><tr><th>Titel</th><th>Autor</th></tr>";
    // Daten aus jeder Zeile ausgeben
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["titel"] . "</td><td>" . $row["autor"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 Ergebnisse";
}
$conn->close();
?>
