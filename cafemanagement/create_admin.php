<?php
include 'db_connect.php';

$username = "admin";
$password = password_hash("admin123", PASSWORD_BCRYPT); 

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin</title>
    <style>
        body {
            background: #fef8f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background-color: #fff8f2;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        h2 {
            color: #854836;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Create Admin Account</h2>
    <?php
    if ($stmt->execute()) {
        echo '<div class="success">Admin created successfully.</div>';
    } else {
        echo '<div class="error">Error: ' . $stmt->error . '</div>';
    }
    ?>
</div>
</body>
</html>