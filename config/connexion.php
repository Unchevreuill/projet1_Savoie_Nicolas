<?php
$server = 'localhost';
$userName = "root";
$pwd = "";
$db = "site_jeux";

$conn = mysqli_connect($server, $userName, $pwd, $db);
if ($conn) {
    echo "Connected to the $db database successfully";
    global $conn;
} else {
    echo "Error : Not connected to the $db database";
}
?>