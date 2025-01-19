<?php
session_start();
require 'start.php';

if (!isset($_SESSION['admin'])) {
    header('Location: Login.php');
    exit;
}

$sql = "SELECT nom, prenom FROM administrateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $_SESSION['admin']]);
$admin = $stmt->fetch();

if (!$admin) {
    echo "<p style='color: red;'>Administrateur introuvable.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .dashboard-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        .dashboard-container h1 {
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .dashboard-container a {
            display: block;
            margin: 15px 0;
            padding: 12px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
            font-weight: 600;
        }
        .dashboard-container a:hover {
            background-color: #4cae4c;
        }
        .dashboard-container a i {
            margin-right: 10px;
        }
        .dashboard-container .logout {
            background-color: #d9534f;
        }
        .dashboard-container .logout:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Bienvenue, <?= htmlspecialchars($admin['prenom']) . ' ' . htmlspecialchars($admin['nom']); ?></h1>
    <a href="ajouthotels.php"><i class="fa fa-hotel"></i>Modifier la liste des hôtels</a>
    <a href="ajoutrestaurants.php"><i class="fa fa-utensils"></i>Modifier la liste des restaurants</a>
    <a href="ajoutsalles.php"><i class="fa fa-building"></i>Modifier la liste des salles</a>
    <a href="reservations.php"><i class="fa fa-calendar-check"></i>Gérer les réservations</a>
    <a href="charte.php"><i class="fa fa-calendar-check"></i>Voir graphe de réservation</a>
    <a href="login.php" class="logout"><i class="fa fa-sign-out-alt"></i>Se déconnecter</a>

</div>
</body>
</html>
