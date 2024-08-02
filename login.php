<?php
session_start();
include 'config.php';

// Initialize the error message
$_SESSION['error_message'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a SQL statement to fetch user data
    $sql = "SELECT id, password FROM teachers WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start a session and set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect to teacher dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}

// Redirect back to login page with error message
header("Location: login.html");
exit();
?>
