<?php
$servername = 'BAI-Proj-mysql-container';
$dbname = 'bai';
$username = 'baiuser'; // Change if needed
$password = 'baipassword'; // Change if needed

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Set security headers
header("Content-Security-Policy: default-src 'self'");
?>
