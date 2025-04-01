<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isLoggedIn()) {
    redirect('../../login.php');
}

// Verifica se o usuário tem permissão de administrador
if (!isAdmin()) {
    die('Acesso negado: você não tem permissão para acessar esta página.');
}

echo "Bem-vindo, administrador!";
?>
