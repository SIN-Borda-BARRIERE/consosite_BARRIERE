<?php
declare(strict_types=1);

/*
⚠️ Ce fichier SIMULE une session HTTP complète
⚠️ Il est NORMAL qu'il soit plus complexe
*/

$cookieFile = __DIR__ . "/cookie.txt";

/* 1️⃣ Appel à une page qui crée la session */
$ch = curl_init("http://localhost/site/auth/login.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_exec($ch);
curl_close($ch);

/* 2️⃣ Appel API AVEC le cookie de session */
$data = [
    "date" => "2026-01-10",
    "kwh" => 15
];

$ch = curl_init("http://localhost/site/api/save_value.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

echo curl_exec($ch);
curl_close($ch);
