<?php
session_start();
require_once "../database.php";

$stmt = $pdo->prepare("
    SELECT 1 FROM electricity_consumption
    WHERE user_id = ? AND date = CURDATE()
");
$stmt->execute([$_SESSION['user_id']]);

echo json_encode(["exists" => $stmt->fetch() ? true : false]);
