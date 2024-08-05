<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Account Management</title>
    <link rel="stylesheet" href="generate_student.css"> <!-- Assuming this CSS file contains all styles -->
</head>
<body class="student-creation-body">
    <header class="student-creation-header">
        <h1>Student Account Management</h1>
        <nav class="header-nav">
            <form action="dashboard.php" method="get" style="display: inline;">
                <button class="header-button" type="submit">Back to Dashboard</button>
            </form>
            <form action="logout.php" method="post" style="display: inline;">
                <button class="header-button" type="submit">Logout</button>
            </form>
        </nav>
    </header>
    <main class="student-creation-main">
        <section class="student-creation-section">
            <h2>Create New Student Account</h2>
            <?php if (isset($message) && $message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form class="student-creation-form" action="user_generation.php" method="post">
                <label for="student_name">Student Name:</label>
                <input type="text" id="student_name" name="student_name" required>
                <button type="submit" name="create_student">Create Student</button>
            </form>
        </section>

        <section class="student-creation-section">
            <h2>Existing Student Accounts</h2>
            <form action="user_generation.php" method="post">
                <button type="submit" name="show_students">Show Students</button>
            </form>
            <?php if (isset($students) && count($students) > 0): ?>
                <table class="student-list-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['id']); ?></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['password']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer class="student-creation-footer">
        <p>RecycleRight</p>
    </footer>
</body>
</html>
