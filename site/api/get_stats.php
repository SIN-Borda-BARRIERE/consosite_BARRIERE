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

$period = $_GET['period'] ?? 'day';

switch ($period) {

    case 'week':
        $sql = "
        SELECT 
            CONCAT(YEAR(date), '-W', LPAD(WEEK(date, 1), 2, '0')) AS label,
            SUM(kwh) AS total
        FROM electricity_consumption
        WHERE user_id = :user_id
        GROUP BY YEAR(date), WEEK(date, 1)
        ORDER BY YEAR(date), WEEK(date, 1)
        ";
        break;

    case 'month':
        $sql = "
        SELECT 
            DATE_FORMAT(date, '%Y-%m') AS label,
            SUM(kwh) AS total
        FROM electricity_consumption
        WHERE user_id = :user_id
        GROUP BY YEAR(date), MONTH(date)
        ORDER BY YEAR(date), MONTH(date)
        ";
        break;

    default:
        $sql = "
        SELECT date AS label, kwh AS total
        FROM electricity_consumption
        WHERE user_id = :user_id
        ORDER BY date
        ";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":user_id" => $_SESSION['user_id']
]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
