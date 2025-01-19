<?php
session_start();
if (!isset($_SESSION['admin']) || !is_string($_SESSION['admin'])) {
    header('Location: Login.php');
    exit;
}

require 'start.php';

$hotelsReservee = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE type_etablissement = 'hotel'")->fetchColumn();
$restaurantsReservee = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE type_etablissement = 'restaurant'")->fetchColumn();
$sallesReservee = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE type_etablissement = 'salle'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Réservations</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 20px;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .chart-container {
            width: 60%;
            margin: 40px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Statistiques des Réservations</h1>

<div class="chart-container">
    <canvas id="reservationChart"></canvas>
</div>

<div class="button-container">
    <button onclick="window.location.reload();">Rafraîchir</button>
    <button onclick="window.location.href = 'menu1.php';">Retour au menu</button>
</div>

<script>
    const data = {
        labels: ['Hôtels Réservés', 'Restaurants Réservés', 'Salles Réservées'],
        datasets: [{
            label: 'Nombre de Réservations',
            data: [<?= $hotelsReservee ?>, <?= $restaurantsReservee ?>, <?= $sallesReservee ?>],
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Réservations par Catégorie',
                    font: {
                        size: 18
                    }
                }
            }
        }
    };

    const reservationChart = new Chart(
        document.getElementById('reservationChart'),
        config
    );
</script>

</body>
</html>
