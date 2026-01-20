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
    <title>Historique</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../app.js?v=<?= time() ?>" defer></script>
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

<h2>Ajouter / Modifier une consommation</h2>

<form id="add-history-form">
    <input type="date" id="history-date" required>
    <input type="number" step="0.01" id="history-kwh" required>
    <button type="submit">Enregistrer</button>
</form>

<p id="history-message"></p>

<h2>Historique des consommations</h2>

<table border="1">
    <thead>
        <tr>
            <th>Date</th>
            <th>kWh</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="history-table"></tbody>
</table>

</body>
</html>
