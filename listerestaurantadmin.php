<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require "start.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM restaurants WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$stmt = $pdo->query("SELECT * FROM restaurants");
$restaurants = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Restaurants</title>
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

        .list-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
            margin: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        th {
            background-color: #007bff; /* Blue color */
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #dc3545; /* Red color */
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c82333; /* Darker red */
        }

        .action-btns {
            display: flex;
            justify-content: center;
        }

        .action-btns a {
            margin-left: 10px;
        }

        .no-record {
            color: #999;
            font-size: 16px;
            font-style: italic;
        }

        .back-btn {
            background-color: #28a745; /* Green color */
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #218838; /* Darker green */
        }

        .modify-btn {
            background-color: #ffc107; /* Yellow color */
            color: #333;
        }

        .modify-btn:hover {
            background-color: #e0a800; /* Darker yellow */
        }
    </style>
</head>
<body>

<div class="list-container">
    <h1>Liste des Restaurants</h1>
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Ville</th>
            <th>Code Postal</th>
            <th>Téléphone</th>
            <th>Description</th>
            <th>Date de Création</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($restaurants): ?>
            <?php foreach ($restaurants as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nom']) ?></td>
                    <td><?= htmlspecialchars($r['adresse']) ?></td>
                    <td><?= htmlspecialchars($r['ville']) ?></td>
                    <td><?= htmlspecialchars($r['code_postal']) ?></td>
                    <td><?= htmlspecialchars($r['telephone']) ?></td>
                    <td><?= htmlspecialchars($r['description']) ?></td>
                    <td><?= htmlspecialchars($r['date_creation']) ?></td>
                    <td class="action-btns">
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $r['id'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                        <a href="modifierrestaurant.php?id=<?= $r['id'] ?>">
                            <button type="button" class="modify-btn">Modifier</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="no-record">Aucun restaurant enregistré.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="ajoutrestaurants.php" class="back-btn">Fermer</a>
</div>

</body>
</html>