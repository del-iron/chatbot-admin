<?php
// Configurações básicas do sistema
define('SITE_NAME', 'Chatbot Moodle');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/chatbot-admin/');

// Configurações de sessão
session_start();

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=chatbot', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}
?>