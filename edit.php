<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: list.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM results WHERE student_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    header("Location: list.php");
    exit();
}

if (isset($_POST['update'])) {

    $student_name = trim($_POST['student_name']);
    $matric_no = trim($_POST['matric_no']);
    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);

    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $final_exam = $_POST['final_exam'];

    $stmt = $conn->prepare(
        "UPDATE results SET
            student_name = ?,
            matric_no = ?,
            subject_name = ?,
            subject_code = ?,
            test1 = ?,
            test2 = ?,
            final_exam = ?,
            final_marks = NULL,
            grade = NULL
         WHERE student_id = ?"
    );

    $stmt->bind_param(
        "sssssssi",
        $student_name,
        $matric_no,
        $subject_name,
        $subject_code,
        $test1,
        $test2,
        $final_exam,
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: list.php");
        exit();
    } else {
        $error = "Failed to update the student record.";
        $stmt->close();
    }

    $row['student_name'] = $student_name;
    $row['matric_no'] = $matric_no;
    $row['subject_name'] = $subject_name;
    $row['subject_code'] = $subject_code;
    $row['test1'] = $test1;
    $row['test2'] = $test2;
    $row['final_exam'] = $final_exam;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Results</title>
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
            <h1>Edit Student Results</h1>
        </div>
    </div>

    <div class="form-container">

        <?php if ($error !== ""): ?>
            <p style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="post" action="edit.php?id=<?php echo $id; ?>">

            <div class="form-row">

                <div class="form-group">
                    <label for="student_name">Student Name</label>
                    <input type="text" id="student_name"
                        name="student_name"
                        value="<?php echo htmlspecialchars($row['student_name']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="matric_no">Matric Number</label>
                    <input type="text" id="matric_no"
                        name="matric_no"
                        value="<?php echo htmlspecialchars($row['matric_no']); ?>"
                        required>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="subject_name">Subject Name</label>
                    <input type="text" id="subject_name"
                        name="subject_name"
                        value="<?php echo htmlspecialchars($row['subject_name']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="subject_code">Subject Code</label>
                    <input type="text" id="subject_code"
                        name="subject_code"
                        value="<?php echo htmlspecialchars($row['subject_code']); ?>"
                        required>
                </div>

            </div>

            <div class="marks-row">

                <div class="form-group">
                    <label for="test1">Test 1 (Max 20)</label>
                    <input type="number" id="test1"
                        name="test1" min="0" max="20"
                        step="0.01"
                        value="<?php echo htmlspecialchars((string)$row['test1']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="test2">Test 2 (Max 30)</label>
                    <input type="number" id="test2"
                        name="test2" min="0" max="30"
                        step="0.01"
                        value="<?php echo htmlspecialchars((string)$row['test2']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="final_exam">Final Exam (Max 50)</label>
                    <input type="number" id="final_exam"
                        name="final_exam" min="0" max="50"
                        step="0.01"
                        value="<?php echo htmlspecialchars((string)$row['final_exam']); ?>"
                        required>
                </div>

            </div>

            <div class="form-action">
                <a href="list.php" class="btn-cancel">Cancel</a>
                <input type="submit" name="update"
                    value="Update" class="btn-submit">
            </div>

        </form>
    </div>

</main>

</body>
</html>