<?php
header("Content-Type: application/json");

// Database credentials
$host = "localhost";
$db   = "portfolio_db";
$user = "root";        // change if different
$pass = "Sai@426503";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Insert form data
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, subject, message, submission_date) 
                            VALUES (:name, :email, :subject, :message, NOW())");
        $stmt->execute([
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':subject' => $_POST['subject'],
            ':message' => $_POST['message']
        ]);

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "DB Connection failed: " . $e->getMessage()]);
}
