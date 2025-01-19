<?php
session_start();
require 'start.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = trim($_POST['password']);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez entrer un email valide.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        $stmt1 = $pdo->prepare("SELECT * FROM administrateurs WHERE email = ?");
        $stmt1->execute([$email]);
        $admin = $stmt1->fetch();

        if ($user) {

            if (isPasswordHashed($user['mot_de_passe'])) {
                if (password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user'] = $email;
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    header('Location: menu.php');
                    exit;
                } else {
                    $error = "Mot de passe incorrect pour l'utilisateur.";
                }
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?");
                $stmt->execute([$hashedPassword, $email]);

                if ($password === $user['mot_de_passe']) {
                    $_SESSION['user'] = $email;
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    header('Location: menu.php');
                    exit;
                } else {
                    $error = "Mot de passe incorrect pour l'utilisateur.";
                }
            }
        } elseif ($admin) {

            if (isPasswordHashed($admin['mot_de_passe'])) {

                if (password_verify($password, $admin['mot_de_passe'])) {
                    $_SESSION['admin'] = $email;
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    header('Location: menu1.php');
                    exit;
                } else {
                    $error = "Mot de passe incorrect pour l'administrateur.";
                }
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE administrateurs SET mot_de_passe = ? WHERE email = ?");
                $stmt->execute([$hashedPassword, $email]);
                if ($password === $admin['mot_de_passe']) {
                    $_SESSION['admin'] = $email;
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    header('Location: menu1.php');
                    exit;
                } else {
                    $error = "Mot de passe incorrect pour l'administrateur.";
                }
            }
        } else {
            $error = "Aucun utilisateur ou administrateur trouvé avec cet email.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Réservation</title>
    <style>
        /* Background setup */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-image: url('background_reservation.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Semi-transparent overlay */
        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Login box */
        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            width: 350px;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        /* Title */
        .login-container h1 {
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Labels */
        .login-container label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
            color: #555;
            font-weight: bold;
            font-size: 14px;
        }

        /* Inputs */
        .login-container input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .login-container input:focus {
            border-color: #5cb85c;
            box-shadow: 0 0 8px rgba(92, 184, 92, 0.4);
            outline: none;
        }

        /* Submit Button */
        .login-container button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .login-container button:hover {
            background-color: #4cae4c;
        }

        /* Error Message */
        .error {
            color: #ff4d4d;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        /* Footer note */
        .login-container .note {
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>


<div class="overlay"></div>
<div class="login-container">
    <h1>Connexion</h1>
    <form method="POST">
        <label for="email">Email :</label>
        <input type="text" name="email" placeholder="Entrez votre email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" placeholder="Entrez votre mot de passe" required>

        <button type="submit">Se connecter</button>
    </form>


    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>


    <p class="note">Accédez à vos réservations d'hôtel, de restaurant et de salle en toute simplicité.</p>
</div>

</body>
</html>
