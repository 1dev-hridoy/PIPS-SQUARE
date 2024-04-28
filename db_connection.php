<?php
$servername = "sever_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_db_name";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
