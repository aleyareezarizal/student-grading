<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if (isset($_POST['save'])) {
    $student_name = trim($_POST['student_name']);
    $matric_no = trim($_POST['matric_no']);
    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);

    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $final_exam = $_POST['final_exam'];

    $stmt = $conn->prepare(
        "INSERT INTO results
        (student_name, matric_no, subject_name, subject_code,
         test1, test2, final_exam, final_marks, grade)
        VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL)"
    );

    $stmt->bind_param(
        "sssssss",
        $student_name,
        $matric_no,
        $subject_name,
        $subject_code,
        $test1,
        $test2,
        $final_exam
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: list.php");
        exit();
    } else {
        $error = "Failed to save the student record.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grading System</title>
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
            <h1>Add Student Results</h1>
        </div>
    </div>

    <div class="form-container">

        <?php if ($error !== ""): ?>
            <p style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="post" action="add.php">

            <div class="form-row">
                <div class="form-group">
                    <label for="student_name">Student Name</label>
                    <input type="text" id="student_name"
                        name="student_name"
                        placeholder="Enter student name"
                        value="<?php echo htmlspecialchars($_POST['student_name'] ?? ''); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="matric_no">Matric Number</label>
                    <input type="text" id="matric_no"
                        name="matric_no"
                        placeholder="Enter matric number"
                        value="<?php echo htmlspecialchars($_POST['matric_no'] ?? ''); ?>"
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="subject_name">Subject Name</label>
                    <input type="text" id="subject_name"
                        name="subject_name"
                        placeholder="Enter subject name"
                        value="<?php echo htmlspecialchars($_POST['subject_name'] ?? ''); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="subject_code">Subject Code</label>
                    <input type="text" id="subject_code"
                        name="subject_code"
                        placeholder="Enter subject code"
                        value="<?php echo htmlspecialchars($_POST['subject_code'] ?? ''); ?>"
                        required>
                </div>
            </div>

            <div class="marks-row">

                <div class="form-group">
                    <label for="test1">Test 1</label>
                    <input type="number" id="test1"
                        name="test1" min="0" max="20"
                        step="0.01" placeholder="0 - 20"
                        value="<?php echo htmlspecialchars($_POST['test1'] ?? ''); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="test2">Test 2</label>
                    <input type="number" id="test2"
                        name="test2" min="0" max="30"
                        step="0.01" placeholder="0 - 30"
                        value="<?php echo htmlspecialchars($_POST['test2'] ?? ''); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="final_exam">Final Exam</label>
                    <input type="number" id="final_exam"
                        name="final_exam" min="0" max="50"
                        step="0.01" placeholder="0 - 50"
                        value="<?php echo htmlspecialchars($_POST['final_exam'] ?? ''); ?>"
                        required>
                </div>

            </div>

            <div class="form-action">
                <a href="list.php" class="btn-cancel">Cancel</a>
                <input type="submit" name="save"
                    value="Save" class="btn-submit">
            </div>

        </form>
    </div>

</main>
</body>
</html>