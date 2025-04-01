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

$pageTitle = "Adicionar Pergunta";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pergunta = $_POST['pergunta'] ?? '';
    $resposta = $_POST['resposta'] ?? '';
    $contexto = $_POST['contexto'] ?? '';
    $palavras_chave = $_POST['palavras_chave'] ?? '';

    if (!empty($pergunta) && !empty($resposta)) {
        try {
            $pergunta_id = addPergunta($pergunta, $resposta, $contexto);

            if (!empty($palavras_chave)) {
                addPalavrasChave($pergunta_id, $palavras_chave);
            }

            $success = 'Pergunta adicionada com sucesso!';
        } catch (Exception $e) {
            $error = 'Erro ao adicionar a pergunta: ' . $e->getMessage();
        }
    } else {
        $error = 'Pergunta e resposta são obrigatórias.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="adicionar.css"> <!-- CSS exclusivo para esta página -->
</head>
<body>
<div class="container">
    <h1>Adicionar Nova Pergunta</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="pergunta">Pergunta *</label>
            <textarea id="pergunta" name="pergunta" rows="3" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="resposta">Resposta *</label>
            <textarea id="resposta" name="resposta" rows="5" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="contexto">Contexto (opcional)</label>
            <textarea id="contexto" name="contexto" rows="3" class="form-control"></textarea>
            <small class="text-muted">Informações adicionais que podem ajudar o chatbot a entender melhor a pergunta.</small>
        </div>
        
        <div class="form-group">
            <label for="palavras_chave">Palavras-chave (opcional)</label>
            <input type="text" id="palavras_chave" name="palavras_chave" class="form-control">
            <small class="text-muted">Separe as palavras-chave por vírgula. Ex: login, acesso, senha</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Pergunta</button>
            <a href="listar.php" class="btn btn-secondary" target="_blank">Cancelar</a>
        </div>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>
</body>
</html>