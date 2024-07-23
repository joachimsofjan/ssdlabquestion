<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['password'])) {
    header('Location: index.php');
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
</head>
<body>
    <h1>Welcome</h1>
    <p>Your password: <?php echo htmlspecialchars($_SESSION['password']); ?></p>
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
