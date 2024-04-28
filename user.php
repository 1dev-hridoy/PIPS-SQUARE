<?php
/*
 * Copyright (c) 2024 BDNOOBRA
 * YouTube: https://www.youtube.com/channel/UCVPO1ux03M6GTvFt1vDkclA
 * Sketchub: https://web.sketchub.in/u/BDNOOBRA
 */

require_once("db_connection.php");

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $response_data = array_merge(array("status" => "success"), $user_data);

        header('Content-Type: application/json');
        echo json_encode($response_data);
        exit();
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Content-Type: application/json');
        echo json_encode(array("status" => "error", "message" => "User not found."));
        exit();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("status" => "error", "message" => "No username provided."));
    exit();
}
?>
