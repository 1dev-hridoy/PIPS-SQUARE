<?php
/*
 * Copyright (c) 2024 BDNOOBRA
 * YouTube: https://www.youtube.com/channel/UCVPO1ux03M6GTvFt1vDkclA
 * Sketchub: https://web.sketchub.in/u/BDNOOBRA
 */

header('Content-Type: application/json'); 

require_once("db_connection.php");

function loginUser($username, $password, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        mysqli_stmt_close($stmt);
        return array("status" => "error", "message" => "No such user found.");
    }

    mysqli_stmt_bind_result($stmt, $userId, $hashedPassword);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        mysqli_stmt_close($stmt);
        return array("status" => "success", "message" => "Login successful.");
    } else {
        mysqli_stmt_close($stmt);
        return array("status" => "error", "message" => "Invalid password.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login_result = loginUser($username, $password, $conn);
    echo json_encode($login_result);
    exit();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method or missing fields."));
    exit();
}
?>
