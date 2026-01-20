<?php
require_once "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    echo "Utilisateur créé ! <a href='login.php'>Connexion</a>";
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
    <button type="submit">S'inscrire</button>
</form>
