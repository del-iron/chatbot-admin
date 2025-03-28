<?php
// Sistema de autenticação

/**
 * Verifica se o usuário está logado
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Faz login do usuário
 */
function login($email, $password) {
    global $pdo;

    // Usuário e senha padrão
    $defaultEmail = 'admin@chatbot.com';
    $defaultPassword = '123456';

    if ($email === $defaultEmail && $password === $defaultPassword) {
        $_SESSION['user_id'] = 0; // ID fictício para o usuário padrão
        $_SESSION['user_name'] = 'Administrador';
        $_SESSION['user_type'] = 'admin';
        return true;
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_type'] = $user['tipo'];
        return true;
    }

    return false;
}

/**
 * Faz logout do usuário
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Verifica se o usuário tem permissão de admin
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user_type'] === 'admin';
}

/**
 * Redireciona para uma URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}
?>