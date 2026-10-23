<?php
session_start();
include 'db.php';

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

    <input type="text" placeholder="Student name, matric number, subject name, or code subject" value="">
    <input type="submit" value="Search">
    <a href="list.php">Show All</a><br>



<!-- Start an HTML table. border="1" draws the grid lines; cellpadding adds spacing inside each cell. -->
<div class="table-container">
<table class="user-table">
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

<tbody>
<?php
// $conn->query(...) sends an SQL command to the database and returns the result.
// "SELECT * FROM users" means: fetch ALL columns (*) of every row in the "users" table.
$result = $conn->query("SELECT * FROM results");

// A "while" loop repeats its block once for each row that comes back.
// $result->fetch_assoc() returns the NEXT row as an "associative array"
// (an array whose values are read by column name, e.g. $row['name']).
// When there are no rows left it returns null, which ends the loop.
  $no = 1;
  
while($row = $result->fetch_assoc()) {
  // echo prints HTML to the page. The dots ( . ) glue the text and the variables together.
  // <td> = a normal table cell (table data).
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
      <a href='edit.php?id=".$row['student_id']."' class='btn-edit'>Edit</a> |
      <a href='delete.php?id=".$row['student_id']."' class='btn-delete'>Delete</a>
    </td>
  </tr>";
  // Note: edit.php?id=...  and  delete.php?id=...  put the student's id into the
  // URL, so the next page knows exactly which student to edit or delete.
}
?>

</tbody>
</table>
</div>
</main>
</body>
</html>
