<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: list.php");
    exit();
}

$sql = "SELECT * FROM results WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Record not found.";
    exit();
}

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
<body style="background-color: #f4f6f9; font-family: Arial, sans-serif; margin: 0;">

<header class="topbar">
 <div class="title">Student Grading System</div>
 <nav class="topbar-nav">
  <a href="logout.php" class="link-logout">Log Out</a>
 </nav>
</header>

<main class="main-content" style="padding: 20px;">

<div style="max-width: 480px; 
margin: 40px auto; 
background: #ffffff; 
border: 2px solid #004085; 
border-radius: 8px; 
padding: 25px 30px; 
box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        
<div style="font-size: 1.1rem; font-weight: bold; 
color: #555;
margin-bottom: 4px;">

No. <?php echo htmlspecialchars($row['student_id']); ?>
</div>
<div style="font-size: 1.8rem; 
font-weight: bold; 
color: #004085; 
margin-bottom: 20px; 
padding-bottom: 10px; 
border-bottom: 2px solid #004085;">
<?php echo htmlspecialchars($row['student_name']); ?>
</div>

<div style="display: flex; 
justify-content: space-between; 
margin-bottom: 15px; 
padding-bottom: 15px; 
border-bottom: 1px solid #e0e0e0;">
<div>

<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Subject
</span>

<span style="font-size: 1.1rem; 
font-weight: 600; 
color: #222;">
<?php echo htmlspecialchars($row['subject_name']); ?></span>
</div>

<div style="text-align: right;">
<span style="display: block; 
font-size: 0.8rem; color: #666; 
font-weight: bold; 
text-transform: uppercase;">Subject Code
</span>

<span style="font-size: 1.1rem; 
font-weight: 600; 
color: #222;">
<?php echo htmlspecialchars($row['subject_code']); ?></span>
</div>
</div>

<div style="display: flex; 
justify-content: space-between; 
margin-bottom: 15px; 
padding-bottom: 15px; 
border-bottom: 1px solid #e0e0e0;">
<div>

<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Test 1 (20)
</span>

<span style="font-size: 1rem; 
font-weight: 600; 
color: #222;">
<?php echo number_format($row['test1'], 2); ?></span>
</div>
<div>

<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Test 2 (30)
</span>

<span style="font-size: 1rem; 
font-weight: 600; 
color: #222;">
<?php echo number_format($row['test2'], 2); ?></span>
</div>
<div>

<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Final (50)
</span>

<span style="font-size: 1rem; 
font-weight: 600; 
color: #222;">
<?php echo number_format($row['final_exam'], 2); ?></span>
</div>
</div>

<div style="display: flex; 
justify-content: space-between; 
margin-bottom: 20px;">
<div>

<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Total Mark
</span>

<span style="font-size: 1.1rem; 
font-weight: bold; 
color: #222;">
<?php echo number_format($row['final_marks'], 2); ?></span>
</div>

<div style="text-align: right;">
<span style="display: block; 
font-size: 0.8rem; 
color: #666; 
font-weight: bold; 
text-transform: uppercase;">Grade</span>

<span style="font-size: 1.1rem; 
font-weight: bold; color: #004085;">
<?php echo htmlspecialchars($row['grade']); ?></span>
</div>
</div>

<a href="list.php" style="display: inline-block;
 padding: 8px 16px; 
 background-color: #004085; 
 color: #ffffff; 
 text-decoration: none; border-radius: 4px; 
 font-weight: bold;">&larr; Back to Records</a>
</div>

</main>

</body>
</html>