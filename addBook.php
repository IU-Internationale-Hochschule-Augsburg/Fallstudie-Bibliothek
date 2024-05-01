<?php
// Einfaches Skript zum Hinzufügen von Büchern zur Datenbank
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "meine_bibliothek";

    // Verbindung zur Datenbank herstellen
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Überprüfen Sie die Verbindung
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    // Daten aus dem Formular erhalten
    $titel = $_POST['titel'];
    $autor = $_POST['autor'];

    // SQL zum Hinzufügen eines neuen Buches
    $sql = "INSERT INTO buecher (titel, autor) VALUES ('$titel', '$autor')";

    if ($conn->query($sql) === TRUE) {
        echo "Neues Buch erfolgreich hinzugefügt.";
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<html>
<body>
<h2>Ein Buch hinzufügen</h2>
<form method="post" action="addBook.php">
    Titel: <input type="text" name="titel"><br>
    Autor: <input type="text" name="autor"><br>
    <input type="submit" value="Hinzufügen">
</form>
</body>
</html>
