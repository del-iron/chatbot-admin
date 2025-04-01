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

?>
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="style.css"> <!-- CSS exclusivo para palavras-chave -->
</head>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM palavras_chave WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success_message'] = 'Palavra-chave removida com sucesso!';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erro ao remover a palavra-chave: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = 'ID da palavra-chave não fornecido.';
    }

    redirect('listar.php');
}
?>
