<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . "/../database.php";

header("Content-Type: application/json");

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Non autorisé"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$date = $data['date'] ?? date('Y-m-d');
$kwh  = isset($data['kwh']) ? (float)$data['kwh'] : null;

if ($kwh === null || $kwh < 0) {
    http_response_code(400);
    echo json_encode(["error" => "Valeur invalide"]);
    exit;
}

$check = $pdo->prepare("
    SELECT 1 FROM electricity_consumption
    WHERE user_id = :user_id AND date = :date
");
$check->execute([
    ":user_id" => $_SESSION['user_id'],
    ":date" => $date
]);

$alreadyExists = (bool) $check->fetchColumn();

$sql = "
INSERT INTO electricity_consumption (user_id, date, kwh)
VALUES (:user_id, :date, :kwh)
ON DUPLICATE KEY UPDATE kwh = VALUES(kwh)
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":user_id" => $_SESSION['user_id'],
    ":date"    => $date,
    ":kwh"     => $kwh
]);

echo json_encode([
    "success" => true,
    "updated" => $alreadyExists
]);
