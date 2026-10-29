<?php include 'db.php';

    $id = $_GET['id'];

    if (isset ($_GET['confirm'])){

    $conn->query("DELETE FROM results WHERE student_id=$id");

    header("Location: list.php");
    exit ();
    }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Delete Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="topbar">

    <div class="title">Student Grading System</div>

    <nav class="topbar-nav">
        <a href="list.php">Student Records</a>
        <a href="logout.php" class="link-logout">Log Out</a>
    </nav>

</header>

<main class="main-content">
    <div class="section-header add-user">
        <div>
            <h1>Delete Student</h1>
        </div>
    </div>

    <div class="form-container">

        <h1>Are you sure you want to delete student data?</h1>
        <p>This action cannot be undone. Please double confirm before deleting.</p>

        <div class="form-action">
            <a href="list.php" class="btn-cancel">Cancel</a>
            <a href="delete.php?id=<?php echo $id; ?>&confirm=1" class="btn-submit">Delete</a>
        </div>
    </div>

</body>
</html>