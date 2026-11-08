<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Get the search value entered by the user
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 2. Query the database based on search input
if ($search != '') {
    // Escapes special characters to prevent basic errors/SQL injection
    $safe_search = $conn->real_escape_string($search);
    
    $sql = "SELECT * FROM results 
            WHERE student_name LIKE '%$safe_search%' 
               OR matric_no LIKE '%$safe_search%' 
               OR subject_name LIKE '%$safe_search%' 
               OR subject_code LIKE '%$safe_search%'";
} else {
    // If no search term, fetch all records
    $sql = "SELECT * FROM results";
}

$result = $conn->query($sql);
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

<!-- header page for navigation -->
<header class="topbar">

 <div class="title">Student Grading System</div>

 <nav class="topbar-nav">
  <a href="logout.php" class="link-logout">Log Out</a>
 </nav>

</header>

<main class="main-content">

<div class="section-header">
  <div>
    <h1>Student Records</h1>
  </div>

<!-- A link (the <a> "anchor" tag). Clicking it opens the add-user page. -->
<a href="add.php" class="btn-add">+&nbsp;&nbsp;&nbsp;Add New Data</a>

</div>

    <!-- SEARCH FORM -->
    <form action="" method="GET">
        <input type="text" name="search" placeholder="Student name, matric number, subject name, or code subject" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
        <a href="list.php">Show All</a>
    </form>
    <br>

<!-- Start an HTML table. border="1" draws the grid lines; cellpadding adds spacing inside each cell. -->
<div class="table-container">
<table class="user-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Matric no.</th>
            <th>Subject Name</th>
            <th>Subject Code</th>
            <th>Test 1 (20)</th>
            <th>Test 2 (30)</th>
            <th>Final (50)</th>
            <th>Total (100)</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
    </thead>

<tbody>
<?php
if ($result && $result->num_rows > 0) {
    $no = 1;
    while($row = $result->fetch_assoc()) {
      echo "<tr>
        <td>".$no++."</td>
        <td>".htmlspecialchars($row['student_name'])."</td>
        <td>".htmlspecialchars($row['matric_no'])."</td>
        <td>".htmlspecialchars($row['subject_name'])."</td>
        <td>".htmlspecialchars($row['subject_code'])."</td> 
        <td>".number_format($row['test1'], 2)."</td>
        <td>".number_format($row['test2'], 2)."</td>
        <td>".number_format($row['final_exam'], 2)."</td>
        <td>".number_format($row['final_marks'], 2)."</td>
        <td>".htmlspecialchars($row['grade'])."</td>
        <td>
          <a href='view.php?id=".$row['student_id']."' class='btn-view'>View</a> |
          <a href='edit.php?id=".$row['student_id']."' class='btn-edit'>Edit</a> |
          <a href='delete.php?id=".$row['student_id']."' class='btn-delete' onclick=\"return confirm('Delete record?')\">Delete</a>
        </td>
      </tr>";
    }
} else {
    echo "<tr><td colspan='11' align='center'>No records found.</td></tr>";
}
?>

</tbody>
</table>
</div>
</main>
</body>
</html>
