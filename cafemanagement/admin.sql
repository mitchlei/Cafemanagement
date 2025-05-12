CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

$password = password_hash("admin123", PASSWORD_BCRYPT);
mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('admin', '$password')");