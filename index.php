<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grading</title>
</head>

<body>
    <h1>Student Grading System</h1>

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