<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION["user"] = $user["first_name"];
            echo json_encode(["status" => "success", "message" => "Login successful."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }
}
?>
