<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Grading</title>
</head>

<body>

<header>
    <div class="title">Student Grading System</div>
    <a href="logout.php" class="link-logout">Log Out</a>
</header>

    <hr>

    <h3>Student Records</h3>
    <a href="add.php">+ Add Result</a><br>

    <input type="text" placeholder="Student name, matric number, subject name, or code subject" value="">
    <input type="submit" value="Search">
    <a href="index.php">Show All</a><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Matric no.</th>
            <th>Subject</th>
            <th>Test 1 (20)</th>
            <th>Test 2 (30)</th>
            <th>Final (50)</th>
            <th>Total (100)</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
    </table>

    <hr>

</body>

</html>