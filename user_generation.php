<?php
session_start();
include 'config.php';

// Check if the teacher is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$message = '';

// Handle create student request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_student'])) {
    $studentName = $_POST['student_name'];
    $teacherId = $_SESSION['user_id'];

    // Generate a random password
    $password = generateRandomPassword();

    // Insert the new student into the database
    $sql = "INSERT INTO students (teacher_id, name, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iss", $teacherId, $studentName, $password);
        if ($stmt->execute()) {
            $message = "Student account created successfully!";
        } else {
            $message = "Error creating student account: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}

// Handle show students request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['show_students'])) {
    $teacherId = $_SESSION['user_id'];

    // Fetch existing students for the logged-in teacher
    $sql = "SELECT id, name, password FROM students WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $teacherId);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $students = [];
        $message = "Error retrieving students: " . $conn->error;
    }
}

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

// Close the database connection
$conn->close();

// Include the HTML form to display messages and students
include 'generate_student_form.php';
?>
