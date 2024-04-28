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
    } else {
        $user_data = null;
    }

    mysqli_stmt_close($stmt);
} else {
    $user_data = null;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <?php if ($user_data): ?>
            <div class="profile">
                <div class="profile-data">
                    <label>Username:</label> <?php echo $user_data['username']; ?>
                </div>
                <div class="profile-data">
                    <label>Email:</label> <?php echo $user_data['email']; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="error">User not found or no username provided.</div>
        <?php endif; ?>
    </div>
</body>
</html>
