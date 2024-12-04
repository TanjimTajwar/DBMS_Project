<?php
$host = "localhost";
$username = "root";
$password = "975321";
$database = "dbms_project";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
