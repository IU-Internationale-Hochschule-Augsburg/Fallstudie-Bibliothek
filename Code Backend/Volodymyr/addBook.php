<?php
//mit < + Fragezeichen + 'php' wird Start von php Skript bezeichnet
    // Skript zum Hinzufügen von Büchern zur Datenbank
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    // meine_bibliothek ist name von Datenbank
    $dbname = "meine_bibliothek";

    // Verbindung zur Datenbank mithilfe von mysqli herstellen
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Überprüfung von Verbindung, falls die Verbindung fehlschlägt, wird das Skript mit einer Fehlermeldung abgebrochen 
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen:  " . $conn->connect_error);
    }

    // Daten aus dem Formular erhalten (Diese Zeilen holen die Daten, die im Formular eingegeben wurden, aus der POST-Anfrage.)
    $titel = $_POST['titel'];
    $autor = $_POST['autor'];
    //$autor = $_POST['id']; weitere Bücherparametrs werden später noch hinzugefügt

    // SQL zum Hinzufügen eines neuen Buches zu Tabelle 'buecher'
    $sql = "INSERT INTO buecher (titel, autor) VALUES ('$titel', '$autor')";

    //Hier wird geprüft, ob die SQL-Anweisung erfolgreich war. Im Fehlerfall wird der SQL-Befehl und der Fehler ausgegeben.
    if ($conn->query($sql) === TRUE) {
        echo "Neues Buch erfolgreich hinzugefügt.";
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }

    //hier  wird die Datenbankverbindung geschlossen.
    $conn->close();
}
//Das Fragenzeichen + > in einem PHP-Skript markiert das Ende eines PHP-Codeblocks.
//dann der HTML-Teil des Skripts stellt ein Benutzerinterface bereit, das es Benutzern ermöglicht, Daten über eine Webseite einzugeben
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
