<?php
session_start();

// Path to the blacklist of common passwords
$blacklist_file = '10-million-password-list-top-1000.txt';

// Function to check password against OWASP requirements and blacklist
function verify_password($password, $blacklist_file) {
    // Check for blacklist
    $blacklist = file($blacklist_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($password, $blacklist)) {
        return false; // Password is in blacklist
    }

    // Check length
    if (strlen($password) < 8) {
        return false; // Password is too short
    }

    // Check for uppercase letters, numbers, and special characters
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        return false; // Password does not meet complexity requirements
    }

    return true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if (verify_password($password, $blacklist_file)) {
        $_SESSION['password'] = $password;
        header('Location: welcome.php');
        exit();
    } else {
        $error = 'Password does not meet the requirements or is on the blacklist.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
