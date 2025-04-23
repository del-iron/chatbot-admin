<?php
// Conexão com o banco de dados
$host = '127.0.0.1';
$dbname = 'chatbot_moodle'; // Certifique-se de que o nome do banco está correto
$username = 'root';
$password = ''; // Certifique-se de que a senha está correta para o MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>