<?php
// Configurações básicas do sistema
define('SITE_NAME', 'Chatbot Moodle Admin');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/chatbot-admin/');

// Configurações de sessão
session_start();

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';
?>