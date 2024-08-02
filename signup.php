<?php
session_start();
include 'config.php';

// Initialize the error message
if (!isset($_SESSION['error_message'])) {
    $_SESSION['error_message'] = '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username is already taken
    $sql = "SELECT id FROM teachers WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "Username is already taken.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO teachers (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page
            $_SESSION['error_message'] = ''; // Clear error message on successful signup
            header("Location: login.html");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}

// Redirect back to signup page with error message
header("Location: signup.html");
exit();
?>
