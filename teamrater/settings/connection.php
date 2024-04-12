<?php
$servername = "localhost";
$username = "elikem";
$password = "EATprof@2002Server";
$dbname = "teamrater";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
