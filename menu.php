<?php
include "start.php";
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: Login.php');
    exit;
}

$sql = "SELECT nom, prenom FROM utilisateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $_SESSION['user']]);
$user = $stmt->fetch();

if (!$user) {
    echo "<p style='color: red;'>Utilisateur introuvable.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .dashboard-container h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .dashboard-container a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .dashboard-container a:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Bonjour, <?= htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']); ?></h1>

    <a href="hotels.php">Liste des Hôtels</a>
    <a href="restaurants.php">Liste des Restaurants</a>
    <a href="salles.php">Liste des Salles</a>
    <a href="Login.php">Se déconnecter</a>
</div>
</body>
</html>
