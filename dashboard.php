<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM teachers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($user['username']); ?>!</h1>
    </header>
    <main>
        <nav>
            <!-- Link to the generate student page -->
            <ul>
                <li><a href="generate_student_form.php">Generate Student Accounts</a></li>
            </ul>
        </nav>
        <!-- Other dashboard content -->
        <p>Here is your personalized data and options.</p>
    </main>
    <footer>
        <p>&copy; 2024 Your Company Name</p>
    </footer>
</body>
</html>
