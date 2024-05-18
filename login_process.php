<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'publication_portal');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user is an admin
$admin_email = "adminpass@gmail.com";
$admin_password = "adminpass1122";

if ($email === $admin_email && $password === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: upload.php");
    exit();
}

// Check if the user is a regular user
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            // Redirect regular user to their dashboard or any other page
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password";
        }
    } else {
        $_SESSION['error'] = "User not found";
    }
} else {
    $_SESSION['error'] = "Error executing SQL query: " . $conn->error;
}
$conn->close();
header("Location: login.php");
exit();


?>
