<?php
$servername = "fdb1034.awardspace.net";
$username = "4477624_hridoy";
$password = "1#x}U}3)7a#z1gix";
$dbname = "4477624_hridoy";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
