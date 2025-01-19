<?php
session_start();
if (!isset($_SESSION['user']) || !is_string($_SESSION['user'])) {
    header('Location: Login.php');
    exit;
}

require 'start.php';

if (!isset($_POST['nom']) || empty(trim($_POST['nom']))) {
    echo "<p style='color: red;'>Nom de restaurant manquant.</p>";
    header('Location: Login.php');
    exit;
}

$restaurant_nom = htmlspecialchars($_POST['nom']);

$stmt = $pdo->prepare("SELECT * FROM restaurants WHERE nom = ?");
$stmt->execute([$restaurant_nom]);
$restaurant = $stmt->fetch();

if (!$restaurant) {
    echo "<p style='color: red;'>Restaurant non trouvé.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_reservation'], $_POST['heure_reservation'])) {
    $date_reservation = $_POST['date_reservation'];
    $heure_reservation = $_POST['heure_reservation'];

    if (empty($date_reservation) || empty($heure_reservation)) {
        echo "<p style='color: red;'>Veuillez remplir la date et l'heure de réservation.</p>";
        exit;
    }

    $sql_user = "SELECT id FROM utilisateurs WHERE email = :email";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([':email' => $_SESSION['user']]);
    $utilisateur_id = $stmt_user->fetchColumn();

    if (!$utilisateur_id) {
        echo "<p style='color: red;'>Utilisateur non trouvé.</p>";
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO reservations (utilisateur_id, type_etablissement, etablissement_id, date_reservation, heure_reservation, statut, date_creation_res) 
                               VALUES (?, 'restaurant', ?, ?, ?, 'confirmée', NOW())");
        $stmt->execute([$utilisateur_id, $restaurant['id'], $date_reservation, $heure_reservation]);

        header('Location: menu.php');
        exit;
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de l'enregistrement de la réservation : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un restaurant</title>
    <style>
        /* Style général */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Conteneur principal */
        .container {
            max-width: 600px;
            width: 100%;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Titre */
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Description du restaurant */
        .description {
            color: #555;
            font-size: 16px;
            margin-bottom: 30px;
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Labels */
        label {
            font-weight: 600;
            color: #333;
            text-align: left;
            margin-bottom: 5px;
        }

        /* Champs de saisie */
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="date"]:focus,
        input[type="time"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Bouton de confirmation */
        button {
            background-color: #28a745; /* Vert */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838; /* Vert plus foncé */
        }

        /* Message d'erreur */
        .error {
            color: #dc3545; /* Rouge */
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Réserver le restaurant : <?= htmlspecialchars($restaurant['nom']) ?></h1>
    <p class="description"><?= htmlspecialchars($restaurant['description']) ?></p>

    <form method="POST">
        <input type="hidden" name="nom" value="<?= htmlspecialchars($restaurant['nom']) ?>">

        <div>
            <label for="date_reservation">Date de Réservation :</label>
            <input type="date" name="date_reservation" required>
        </div>

        <div>
            <label for="heure_reservation">Heure de Réservation :</label>
            <input type="time" name="heure_reservation" required>
        </div>

        <button type="submit">Confirmer la Réservation</button>
    </form>
</div>

</body>
</html>