<?php
    // Load environment variables from .env if available
    if (file_exists(__DIR__ . '/.env')) {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = array_map('trim', explode('=', $line, 2));
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
            }
        }
    }

    // Use env vars or fallback to defaults
    $host     = $_ENV['DB_HOST']     ?? '127.0.0.1';
    $port     = $_ENV['DB_PORT']     ?? '3306';
    // Ensure these environment variables are set
    $dbname   = $_ENV['DB_NAME']     ?? 'your_database'; // Change to your database name
    $username = $_ENV['DB_USER']     ?? 'db_username'; // Change to your database username
    $password = $_ENV['DB_PASSWORD'] ?? 'db_password'; // Change to your database password

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $conn = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
        exit;
    }
?>
