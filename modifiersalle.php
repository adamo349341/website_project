<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require "start.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listesallesadmin.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM salles WHERE id = ?");
$stmt->execute([$id]);
$salle = $stmt->fetch();

if (!$salle) {
    header('Location: listesallesadmin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE salles SET nom = ?, adresse = ?, ville = ?, code_postal = ?, telephone = ?, description = ? WHERE id = ?");
    $stmt->execute([$nom, $adresse, $ville, $code_postal, $telephone, $description, $id]);
    header('Location: listesallesadmin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Salle</title>
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
            min-height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #dc3545; /* Red color */
            outline: none;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5); /* Red shadow */
        }

        button {
            background-color: #dc3545; /* Red color */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c82333; /* Darker red */
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #dc3545; /* Red color */
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-btn:hover {
            color: #c82333; /* Darker red */
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Modifier la Salle</h1>
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($salle['nom']) ?>" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($salle['adresse']) ?>" required>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($salle['ville']) ?>" required>

        <label for="code_postal">Code Postal :</label>
        <input type="text" id="code_postal" name="code_postal" value="<?= htmlspecialchars($salle['code_postal']) ?>" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($salle['telephone']) ?>" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($salle['description']) ?></textarea>

        <button type="submit">Enregistrer</button>
    </form>
    <a href="listesallesadmin.php" class="back-btn">Retour à la liste des salles</a>
</div>
</body>
</html>