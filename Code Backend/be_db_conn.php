<?php

$sname= "sql11.freesqldatabase.com";
$unmae= "sql11705531";
$password = "AG4ygEPnpN";

$db_name = "sql11705531";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
echo "Connection failed!";

}

?>

