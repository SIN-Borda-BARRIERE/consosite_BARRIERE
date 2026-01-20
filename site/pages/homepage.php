<?php
session_start();
require_once "../database.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
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
    <title>Accueil - Gestion Énergie</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../app.js?v=<?= time() ?>" defer></script>
</head>
<body>

<header>
    <h1>Bienvenue sur votre tableau de gestion énergétique</h1>
    <nav>
        <a href="homepage.php">Accueil</a> |
        <a href="history.php">Historique</a> |
        <a href="dashboard.php">Tableau de bord</a> |
        <a href="../auth/logout.php">Déconnexion</a>
    </nav>
    <h1>Bienvenue, <span style="color:#0099cc;"><?php echo $username; ?></span> 👋</h1>
</header>

<main>
<section>
    <h2>Ajouter la consommation du jour</h2>

    <form id="electricity-form">
        <label for="kwh">Consommation (kWh)</label>
        <input type="number" step="0.01" id="kwh" required>
        <button type="submit">Enregistrer</button>
    </form>

    <p id="form-message"></p>
</section>
<section>
    <h2>Gestion du compte</h2>

    <div class="account-box">
        <h3>Modifier vos informations</h3>

        <button id="show-username-form">Modifier le pseudo</button>
        <form id="update-username-form" style="display:none;">
            <label for="new-username">Nouveau pseudo :</label>
            <input type="text" id="new-username" required>
            <button type="submit">Mettre à jour le pseudo</button>
        </form>

        <button id="show-password-form">Modifier le mot de passe</button>
        <form id="update-password-form" style="display:none;">
            <label for="new-password">Nouveau mot de passe :</label>
            <input type="password" id="new-password" required>
            <button type="submit">Modifier le mot de passe (submit)</button>
        </form>

        <hr>

        <form id="delete-account-form">
            <p style="color:red;">⚠ Cette action est irréversible.</p>
            <button type="submit" class="danger">Supprimer mon compte</button>
        </form>

        <p id="account-message"></p>
    </div>
</section>
</main>

</body>
</html>
