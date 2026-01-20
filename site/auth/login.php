<?php
session_start();
require_once "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../index.php");
        exit;
    } else {
        echo "Identifiants incorrects.";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>Accueil - Gestion Énergie</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../app.js" defer></script>
</head>
<form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>

<p>
    Pas de compte ?
    <a href="register.php">Créer un compte</a>
</p>
