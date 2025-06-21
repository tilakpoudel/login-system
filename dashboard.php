<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
        exit;
    }
    $username = htmlspecialchars($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Hello, <?php echo $username; ?>, welcome to dashboard.</h1>
    <a href="logout.php">Logout</a>
</body>
</html>
