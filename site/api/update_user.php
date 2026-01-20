<?php
session_start();
require_once "../database.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user_id'];

switch ($data['action']) {
    case "update_username":
        $username = trim($data['username']);
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $success = $stmt->execute([$username, $user_id]);
        echo json_encode(["success" => $success]);
        break;

    case "update_password":
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $success = $stmt->execute([$password, $user_id]);
        echo json_encode(["success" => $success]);
        break;

    case "delete_account":
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $success = $stmt->execute([$user_id]);
        if ($success) session_destroy();
        echo json_encode(["success" => $success]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Invalid action"]);
}
