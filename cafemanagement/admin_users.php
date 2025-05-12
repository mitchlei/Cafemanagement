<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin'])) {
    die("Access denied.");
}

$result = $conn->query("SELECT id, name, email FROM users WHERE status = 'pending'");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewLane Cafe - Admin Panel</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('bc4.png') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
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

        .nav-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10;
        }

        .nav-buttons a {
            text-decoration: none;
            color: white;
            background-color: #854836;
            padding: 10px 18px;
            border-radius: 25px;
            margin: 0 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .nav-buttons a:hover {
            background-color: #6d3c28;
        }

        .container {
            max-width: 1600px;
            margin-top: 120px;
            margin-bottom: 40px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px 50px;
            border-radius: 20px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #854836;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .user-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .user-card {
            background-color: #f8f6f5;
            padding: 15px 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-size: 16px;
            color: #333;
        }

        .user-actions a {
            text-decoration: none;
            color: white;
            padding: 8px 14px;
            border-radius: 12px;
            font-size: 14px;
            margin-left: 10px;
        }

        .approve-btn {
            background-color: #4CAF50;
        }

        .approve-btn:hover {
            background-color: #3e8e41;
        }

        .reject-btn {
            background-color: #f44336;
        }

        .reject-btn:hover {
            background-color: #d32f2f;
        }

        .no-requests {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 100px 10px 40px;
            }

            .user-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .user-actions {
                align-self: flex-end;
            }

            .nav-buttons a {
                padding: 6px 10px;
                font-size: 12px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <img src="Logo1.png" alt="BrewLane Logo">
    <h1>BrewLane Cafe</h1>
</div>

<div class="nav-buttons">
    <a href="logout.php">Log out</a>
</div>

<div class="container">
    <h2>Pending User Requests</h2>
    
    <div class="user-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($user = $result->fetch_assoc()): ?>
                <div class="user-card">
                    <div class="user-info">
                        <?php echo htmlspecialchars($user['name']) . " (" . htmlspecialchars($user['email']) . ")"; ?>
                    </div>
                    <div class="user-actions">
                        <a href="approve_user.php?id=<?php echo $user['id']; ?>" class="approve-btn">Approve</a>
                        <a href="reject_user.php?id=<?php echo $user['id']; ?>" 
                           class="reject-btn" 
                           onclick="return confirm('Are you sure you want to reject this user?')">Reject</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-requests">
                No pending user requests at this time.
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>