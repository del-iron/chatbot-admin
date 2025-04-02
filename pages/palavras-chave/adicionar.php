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

$pageTitle = "Adicionar Palavra-chave";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $palavra = $_POST['palavra'] ?? '';
    $pergunta_id = $_POST['pergunta_id'] ?? null;

    if (!empty($palavra) && $pergunta_id) {
        try {
            // Insere a palavra-chave no banco de dados
            $stmt = $pdo->prepare("INSERT INTO palavras_chave (palavra, pergunta_id) VALUES (?, ?)");
            $stmt->execute([$palavra, $pergunta_id]);
            $success = 'Palavra-chave adicionada com sucesso!';
        } catch (Exception $e) {
            $error = 'Erro ao adicionar a palavra-chave: ' . $e->getMessage();
        }
    } else {
        $error = 'Palavra e pergunta associada são obrigatórias.';
    }
}
?>

<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="style.css"> <!-- CSS exclusivo para palavras-chave -->
</head>

<div class="container">
    <h1>Adicionar Nova Palavra-chave</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="palavra">Palavra *</label>
            <input type="text" id="palavra" name="palavra" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="pergunta_id">ID da Pergunta Associada *</label>
            <input type="number" id="pergunta_id" name="pergunta_id" class="form-control" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Palavra-chave</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>