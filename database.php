<?php
//To connect with Database
$hostName = "localhost";
$dbUser = "root";
$dbPassword = ""; // Use the correct password for the 'root' user
$dbName = "library";
$portNo = "3306";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName, $portNo);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>