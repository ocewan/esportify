<?php
$host = 'localhost';
$dbname = 'esportify';
$username = 'root';
$password = '';

date_default_timezone_set('Europe/Paris');

// connexion à la BDD SQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
