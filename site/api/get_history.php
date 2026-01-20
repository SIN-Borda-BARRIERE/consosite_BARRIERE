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

$sql = "
SELECT date, kwh
FROM electricity_consumption
WHERE user_id = :user_id
ORDER BY date ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":user_id" => $_SESSION['user_id']
]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
