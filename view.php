<?php
session_start(); 
include 'db.php'; //important to connect to the database

// 1. Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Get the student record number (e.g., "No . 1")
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Prepare and run the SQL query to fetch ONLY this specific student's record
$sql = "SELECT * FROM results WHERE student_id = ?"; // "?" is a placeholder for the student_id value to prevent SQL injection
$stmt = $conn->prepare($sql); //sending back the blank form to database and telling it to get ready to fill in "?"
$stmt->bind_param("i", $id); //"1" tell MySQL that the value go into "?" just interger
$stmt->execute(); //search the database
$result = $stmt->get_result(); //find result and collect it

// Check if the record exists
if ($result->num_rows === 0) {
echo "Record not found.";
exit();
}

// 4. Store the database record as an array inside $row
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<title>View Student Details</title>
</head>
<body>

<header class="topbar">
<div class="title">Student Grading System</div>
<nav class="topbar-nav">
<a href="logout.php" class="link-logout">Log Out</a>
</nav>
</header>

<main class="main-content">

<div class="card-box">
        
<div class="card-no">No. <?php echo htmlspecialchars($row['student_id']); ?></div>
<div class="card-title"><?php echo htmlspecialchars($row['student_name']); ?></div>

<!-- Student & Subject Info Row -->
<div class="flex-row">
<div>
<span class="label">Matric No.</span>
<span class="value"><?php echo htmlspecialchars($row['matric_no']); ?></span>
</div>
<div class="text-right">
<span class="label">Subject (Code)</span>
<span class="value"><?php echo htmlspecialchars($row['subject_name']) . " (" . htmlspecialchars($row['subject_code']) . ")"; ?></span>
</div>
</div>

<!-- test mark row -->
<div class="flex-row">
<div>
<span class="label">Test 1 (20)</span>
<span class="value-sm"><?php echo number_format($row['test1'], 2); ?></span>
</div>
<div>
<span class="label">Test 2 (30)</span>
<span class="value-sm"><?php echo number_format($row['test2'], 2); ?></span>
</div>
<div>
<span class="label">Final (50)</span>
<span class="value-sm"><?php echo number_format($row['final_exam'], 2); ?></span>
</div>
</div>

<!-- Total Marks & Grade Row -->
<div class="flex-row no-border">
<div>
<span class="label">Total Mark</span>
<span class="value-bold"><?php echo number_format($row['final_marks'], 2); ?></span>
</div>
<div class="text-right">
<span class="label">Grade</span>
<span class="value-highlight"><?php echo htmlspecialchars($row['grade'] ?? ''); ?></span>
</div>
</div>

<a href="list.php" class="btn-back">&larr; Back to Records</a>
</div>

</main>

</body>
</html>