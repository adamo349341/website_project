<?php
session_start();
if (!isset($_SESSION['user']) || !is_string($_SESSION['user'])) {
    header('Location: Login.php');
    exit;
}

require 'start.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM salles WHERE nom LIKE :search");
    $stmt->execute(['search' => '%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM salles");
}

$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Salles</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .menu-button {
            display: inline-block;
            background-color: #28a745; /* Green color */
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .menu-button:hover {
            background-color: #218838; /* Darker green */
        }

        .salle {
            background-color: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        .salle h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .salle p {
            color: #555;
            margin-bottom: 15px;
            font-size: 16px;
        }

        button {
            background-color: #007bff; /* Blue color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3; /* Darker blue */
        }

        #searchBar {
            width: 100%;
            max-width: 800px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #searchBar:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .no-results {
            color: #999;
            font-size: 16px;
            font-style: italic;
        }
    </style>
</head>
<body>

<h1>Liste des Salles</h1>

<form method="GET" action="">
    <input type="text" id="searchBar" name="search" placeholder="Rechercher une salle par nom..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Rechercher</button>
</form>

<?php if (empty($salles)): ?>
    <p class="no-results">Aucune salle trouvée.</p>
<?php else: ?>
    <?php foreach ($salles as $salle): ?>
        <div class="salle">
            <h2><?= htmlspecialchars($salle['nom']) ?></h2>
            <p>Description: <?= htmlspecialchars($salle['description']) ?></p>
            <form action="reserversalle.php" method="POST">
                <input type="hidden" name="nom" value="<?= htmlspecialchars($salle['nom']) ?>">
                <button type="submit">Réserver</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="menu.php" class="menu-button">Retour au menu</a>

</body>
</html>