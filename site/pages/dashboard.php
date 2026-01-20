<?php
session_start();
require_once "../database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
// Récupération du pseudo utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = htmlspecialchars($user['username']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestion Énergie</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../app.js?v=<?= time() ?>"></script>
</head>
<body>

<header>
  <h1>Gestion énergétique</h1>
  <nav>
    <a href="homepage.php">Accueil</a>
    <a href="history.php">Historique</a>
    <a href="dashboard.php">Tableau de bord</a>
    <a href="../auth/logout.php">Déconnexion</a>
    <h1>Bienvenue, <span style="color:#0099cc;"><?php echo $username; ?></span> 👋</h1>
  </nav>
</header>

<h2>Tableau de bord</h2>

<div>
    <button data-period="day">Jour</button>
    <button data-period="week">Semaine</button>
    <button data-period="month">Mois</button>
</div>

<div id="stats-box"></div>

<canvas id="consumptionChart" width="700" height="350"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
