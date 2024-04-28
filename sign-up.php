<?php
/*
 * Copyright (c) 2024 BDNOOBRA
 * YouTube: https://www.youtube.com/channel/UCVPO1ux03M6GTvFt1vDkclA
 * Sketchub: https://web.sketchub.in/u/BDNOOBRA
 */

session_start();

require_once("db_connection.php");

function usernameExists($username, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $num_rows > 0;
}

function emailExists($email, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $num_rows > 0;
}

function signupAndLogin($username, $email, $password, $conn) {
    if (usernameExists($username, $conn)) {
        return json_encode(array("status" => "error", "message" => "Username already exists."));
    }
    if (emailExists($email, $conn)) {
        return json_encode(array("status" => "error", "message" => "Email already exists."));
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_stmt_insert_id($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        return json_encode(array("status" => "success", "message" => "Signup and login successful."));
    } else {
        mysqli_stmt_close($stmt);
        return json_encode(array("status" => "error", "message" => "Signup failed."));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $signup_result = signupAndLogin($username, $email, $password, $conn);
    echo $signup_result;
    exit();
}

echo json_encode(array("status" => "error", "message" => "Invalid request."));
exit();
?>
