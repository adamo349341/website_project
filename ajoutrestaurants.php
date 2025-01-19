<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require 'start.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$stmt = $pdo->query("SELECT * FROM restaurants");
$restaurants = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $code_postal = htmlspecialchars(trim($_POST['code_postal']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $description = htmlspecialchars(trim($_POST['description']));
    $date_creation = htmlspecialchars(trim($_POST['date_creation']));

    $stmt = $pdo->prepare("INSERT INTO restaurants (nom, adresse, ville, code_postal, telephone, description, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $adresse, $ville, $code_postal, $telephone, $description, $date_creation]);
    $message = "<p class='success-message'>Restaurant ajouté avec succès.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Restaurants</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f4f7fc;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            width: 100%;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            margin: 20px 0;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .navigation a button {
            width: 100%;
            background-color: #28a745;
        }

        .navigation a button:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>Tableau de Bord - Gestion des Restaurants</header>

<div class="container">
    <h2 class="form-title">Ajouter un Restaurant</h2>
    <?php if (isset($message)) echo $message; ?>

    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" placeholder="Nom du restaurant" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" placeholder="Adresse complète" required>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" placeholder="Ville" required>

        <label for="code_postal">Code Postal :</label>
        <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" placeholder="Numéro de téléphone" required>

        <label for="description">Description :</label>
        <input type="text" id="description" name="description" placeholder="Description du restaurant" required>

        <label for="date_creation">Date de Création :</label>
        <input type="date" id="date_creation" name="date_creation" required>

        <button type="submit">Ajouter le Restaurant</button>
    </form>
</div>

<div class="container navigation">
    <a href="menu1.php"><button>Retour au Menu</button></a>
    <a href="listerestaurantadmin.php"><button>Liste des Restaurants</button></a>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Gestion des Restaurants. Tous droits réservés.
</footer>

</body>
</html>