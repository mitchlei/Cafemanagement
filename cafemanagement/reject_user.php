<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: admin_users.php?message=User+rejected+successfully");
    } else {
        echo "Failed to reject user: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
$conn->close();
?>

<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin_users.php");
exit;

