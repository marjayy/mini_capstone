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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Products</title>
    <link rel="shortcut icon" type="x-icon" href="image/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
      background-color: #f8f9fa;
    }

    .dashboard-header {
      background-color: #000000;
      color: #ffffff;
      padding: 10px 20px;
    }

    .dashboard-card {
      text-align: center;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
      cursor: pointer;
    }

    .dashboard-card h5 {
      font-size: 24px;
      font-weight: 600;
      margin: 0;
    }

    .dashboard-card p {
      font-size: 18px;
      font-weight: bold;
      margin-top: 5px;
    }

    .table th, .table td {
      text-align: center;
    }

    .table th {
      background-color: #343a40;
      color: white;
    }

    .table td button {
      margin: 0 5px;
    }

    .left-logo {
      max-width: 13%;
    }

    .row.g-4 {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .col-md-2 {
      flex: 1 1 22%;
      margin-bottom: 20px;
    }

    .header {
      background-color: #000000;
      color: #ffffff;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header .logo {
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
    }

    .header .logo img {
      max-width: 160px;
      margin-right: 10px;
    }

    .header .title {
      font-size: 22px;
      font-weight: 600;
    }

    .header .icons {
      display: flex;
      align-items: center;
    }

    .header .icons i {
      font-size: 20px;
      margin-left: 20px;
      cursor: pointer;
    }

    .header .icons i:hover {
      color: #ddd;
    }
    .table {
        border-color: #000000;
        background-color: #ffffff;
    }
    .table th {
        background-color: #ffffff;
        color: #000000;
    }

    .card {
        border-radius: 0px;
        border-color: #000000;
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: #ffffff;
    }

   /* Style for the search bar */
    .search-box {
    display: flex;
    justify-content: flex-end;
    }   

    .search-box input {
    width: 250px; /* Adjust this for the size of the search box */
    padding: 1px 20px; /* Adjust the internal space inside the box */
    font-size: 15px; /* Increase font size for better readability */
    border-radius: 5px;
    border: 1px solid #000000;
   
    }

    .search-box button {
    margin-left: 10px;
    background-color: #000000;
    border: none;
    border-radius: 5px;
    padding: 5px 10px; /* Adjust button size */
    cursor: pointer;
    }

    .search-box button:hover {
    background-color: #ffffff;
    }
  </style>
</head>
<body>
<div class="header">
    <div class="logo">
      <img src="image/logo1.png" alt="ESSEN Logo">
    </div>
    <div class="title">Admin Dashboard</div>
    <div class="icons">
      <i class="bi bi-bell"></i>
      <i class="bi bi-person-circle"></i>
      <i class="bi bi-power"></i>
    </div>
  </div>

<div class="container mt-5">
    <h2>User Management</h2>

    <!-- Add User Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Add User</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="user_management.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>

    <!-- User List Table -->
    <div class="card">
        <div class="card-header">
            <h5>All Users</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user['user_id'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <a href="edit_user.php?user_id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="user_management.php?delete_user_id=<?= $user['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
