<?php
session_start();
include 'db_config.php'; // Include your database connection

// Handle Add User
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password hashing
    $role = $_POST['role'];

    $stmt = $pdo->prepare("CALL AddUser(:username, :email, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
}

// Handle Edit User
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password hashing
    $role = $_POST['role'];

    $stmt = $pdo->prepare("CALL EditUser(:user_id, :username, :email, :password, :role)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
}

// Handle Delete User
if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];

    $stmt = $pdo->prepare("CALL DeleteUser(:user_id)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

// Fetch users
$users = [];
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
