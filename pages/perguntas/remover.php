<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    redirect('../../login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            deletePergunta($id);
            $_SESSION['success_message'] = 'Pergunta removida com sucesso!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao remover a pergunta: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'ID da pergunta não fornecido.';
    }

    redirect('../../index.php');
}
?>
