<?php
$host = 'localhost';
$dbname = 'unifit';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conectado com sucesso via PDO
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
