<?php
session_start();

// Hardcoded username and password
$valid_username = "mohamed";
$valid_password = "1111";

// Define variables to store username and password from the form
$username = $password = "";

// Define variable to store error message
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve entered username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if entered username and password match the hardcoded values
    if ($username === $valid_username && $password === $valid_password) {
        // If credentials are correct, start a session and store username
        $_SESSION['username'] = $username;
        header("Location: web.php"); // Redirect to main page after login
        exit(); // Terminate script execution after redirect
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="box">
        <span class="borderline"></span>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Sign in</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="inputbox">
                <input type="text" name="username" required="required">
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" required="required">
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="#">Forget Password</a>
                <a href="#">Signup</a>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>