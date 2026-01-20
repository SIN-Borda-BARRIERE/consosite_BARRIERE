<?php
session_start();
require_once "../database.php";

if (!isset($_SESSION['user_id'])) exit;

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="consumption.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Date', 'kWh']);

$stmt = $pdo->prepare("SELECT date, kwh FROM electricity_consumption WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
