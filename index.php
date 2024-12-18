<?php
session_start();
include 'db_config.php'; // Include your database connection

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $identifier = $_POST['student_id']; // This can be student ID or username
    $password = $_POST['password'];

    try {
        // Prepare query to fetch user (check if it's either student_id or username)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE (student_id = :identifier OR username = :identifier) LIMIT 1");
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Compare plain text password
            if ($password === $user['password']) {
                // Store necessary session data
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['student_id'] = $user['student_id']; // Only available for users with a student_id

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => 'admin_dashboard.php']);
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => 'user_dashboard.php']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
