<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require 'start.php';

$stmt = $pdo->query("SELECT * FROM salles ");
$etablissements = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];
    $capacite = $_POST['capacite'];
    $description = $_POST['description'];
    $date_creation = $_POST['date_creation'];
    $stmt = $pdo->prepare("INSERT INTO salles (nom, adresse, code_postal,telephone,capacite,description,date_creation) VALUES (?, ?, ?,?,?,?,?)");
    $stmt->execute([$nom, $adresse, $code_postal,$telephone,$capacite,$description,$date_creation]);
    $message = "<p class='success-message'>Salle ajoutée avec succès.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion des Salles</title>
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
            background-color: #dc3545; /* Red color */
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
            color: #dc3545; /* Red color */
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
            border-color: #dc3545; /* Red color */
            outline: none;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5); /* Red shadow */
        }

        button {
            background-color: #dc3545; /* Red color */
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c82333; /* Darker red */
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .navigation a button {
            width: 100%;
            background-color: #dc3545; /* Red color */
        }

        .navigation a button:hover {
            background-color: #c82333; /* Darker red */
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

<header>Tableau de Bord - Gestion des Salles</header>

<div class="container">
    <h2 class="form-title">Ajouter une Salle</h2>
    <?php if (isset($message)) echo $message; ?>

    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" placeholder="Nom de la salle" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" placeholder="Adresse complète" required>

        <label for="code_postal">Code Postal :</label>
        <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" placeholder="Numéro de téléphone" required>

        <label for="capacite">Capacité :</label>
        <input type="number" id="capacite" name="capacite" placeholder="Capacité de la salle" required>

        <label for="description">Description :</label>
        <input type="text" id="description" name="description" placeholder="Description de la salle" required>

        <label for="date_creation">Date de Création :</label>
        <input type="date" id="date_creation" name="date_creation" required>

        <button type="submit">Ajouter la Salle</button>
    </form>
</div>

<div class="container navigation">
    <a href="menu1.php"><button>Retour au Menu</button></a>
    <a href="listesallesadmin.php"><button>Liste des Salles</button></a>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Gestion des Salles. Tous droits réservés.
</footer>

</body>
</html>