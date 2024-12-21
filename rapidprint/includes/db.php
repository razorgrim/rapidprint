<?php
$servername = "localhost";
$username = "root"; // database username
$password = ""; // database password
$dbname = "rapidprintsystem";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
