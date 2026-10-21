<?php
session_start();
require_once 'db.php';

$error = "";
$username = "";

// Redirect to list.php if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: list.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Reset button
    if (isset($_POST['reset'])) {
        $username = "";
        $error = "";
    }

    // Login button
    elseif (isset($_POST['login'])) {

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Check if form fields are empty
        if ($username == "" || $password == "") {
            $error = "Please enter both username and password.";
        } else {

            // Check username in db
            $stmt = $conn->prepare(
                "SELECT user_id, username, password_hash
                 FROM users
                 WHERE username = ?"
            );

            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Verify password from hashed pass in db
            if ($user && password_verify($password, $user['password_hash'])) {

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];

                header("Location: list.php");
                exit();

            } else {
                $error = "Invalid username or password.";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Student Grading</title>
</head>

<body class="login-body">

    <div class="login-container">
        <h1>Student Grading System</h1>

        <?php if($error != ""): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>"><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password"><br>

        <div class="login-buttons">
            <input type="submit" name="login" value="Login">
            <button type="submit" name="reset">Reset</button>
        </div>
        </form>
    </div>

</body>
</html>
