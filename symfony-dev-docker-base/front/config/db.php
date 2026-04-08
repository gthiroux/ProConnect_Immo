<?php
$host = 'mariadb';
$port = '8081';
$db   = 'symfony';
$user = 'root';
$pass = '*%*a!@poX3kMQ0';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Connexion réussie !";
} catch (\PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}