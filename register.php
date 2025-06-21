<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname   = trim($_POST["fName"]);
    $lname   = trim($_POST["lName"]);
    $email   = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirmPassword"];
    $captcha = $_POST["captchaInput"];

    // var_dump($_POST);


    if ($password !== $confirm) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        exit;
    }

    // if (strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
    //     echo json_encode(["status" => "error", "message" => "Invalid CAPTCHA."]);
    //     exit;
    // }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([$fname, $lname, $email, $hashedPassword]);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Registration successful."]);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(["status" => "error", "message" => "Registration failed: " . $errorInfo[2]]);
    }
}
?>
