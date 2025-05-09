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

$pageTitle = "Editar Palavra-chave";

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    redirect('listar.php');
}

// Busca a palavra-chave pelo ID
$stmt = $pdo->prepare("SELECT * FROM palavras_chave WHERE id = ?");
$stmt->execute([$id]);
$palavraChave = $stmt->fetch();

if (!$palavraChave) {
    redirect('listar.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $palavra = $_POST['palavra'] ?? '';
    $pergunta_id = $_POST['pergunta_id'] ?? null;

    if (!empty($palavra) && $pergunta_id) {
        try {
            $stmt = $pdo->prepare("UPDATE palavras_chave SET palavra = ?, pergunta_id = ? WHERE id = ?");
            $stmt->execute([$palavra, $pergunta_id, $id]);
            $success = 'Palavra-chave atualizada com sucesso!';
        } catch (Exception $e) {
            $error = 'Erro ao atualizar a palavra-chave: ' . $e->getMessage();
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
    <h1>Editar Palavra-chave</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="palavra">Palavra *</label>
            <input type="text" id="palavra" name="palavra" class="form-control" value="<?= $palavraChave['palavra'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="pergunta_id">ID da Pergunta Associada *</label>
            <input type="number" id="pergunta_id" name="pergunta_id" class="form-control" value="<?= $palavraChave['pergunta_id'] ?>" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <button type="button" class="btn btn-secondary" onclick="limparCampos()">Limpar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    function limparCampos() {
        // Limpa os valores dos campos de entrada
        document.getElementById('palavra').value = '';
        document.getElementById('pergunta_id').value = '';
    }
</script>

<?php include '../../includes/footer.php'; ?>
