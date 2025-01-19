<?php
$host = 'localhost';
$db = 'gestionreservations';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
function isPasswordHashed($password) {
    return (strlen($password) === 60 && (substr($password, 0, 4) === '$2y$' || substr($password, 0, 4) === '$2a$'));
}
?>