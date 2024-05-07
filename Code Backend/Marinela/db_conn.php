<?php

$sname= "sql11.freesqldatabase.com";
$unmae= "sql11703805";
$password = "l15w7cSPgl";

$db_name = "sql11703805";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
echo "Connection failed!";

}

?>