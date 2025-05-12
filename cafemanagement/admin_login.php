<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: admin_users.php");
            exit;
        }
    }

    echo "Invalid credentials.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewLane - Admin Login</title>
    <style>
        body {
            background: url('bc4.png') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .header {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            z-index: 10;
        }

        .header img {
            width: 50px;
            margin-right: 10px;
        }

        .header h1 {
            color: #854836;
            font-size: 26px;
            margin: 0;
        }
        .container {
            background: #F7F7F7;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        .container h2 {
            color: #854836;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 25px;
            background-color: #faebd7;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #854836;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #733d2b;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    
<div class="header">
    <img src="Logo1.png" alt="BrewLane Logo">
    <h1>BrewLane Cafe</h1>
</div>

    <div class="container">
        <h2>Admin Login</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="admin_login.php" method="POST">
            <input type="text" name="username" placeholder="Admin Email" class="input-field" required>
            <input type="password" name="password" placeholder="Password" class="input-field" required>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>