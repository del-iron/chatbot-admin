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

$pageTitle = "Editar Pergunta";

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    redirect('listar.php');
}

// Busca a pergunta pelo ID
$pergunta = getPerguntaById($id);

if (!$pergunta) {
    redirect('listar.php');
}

// Busca as palavras-chave associadas
$palavrasChave = getPalavrasChaveByPergunta($id);
$palavrasChaveString = implode(', ', array_column($palavrasChave, 'palavra'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaPergunta = $_POST['pergunta'] ?? '';
    $resposta = $_POST['resposta'] ?? '';
    $contexto = $_POST['contexto'] ?? '';
    $novasPalavrasChave = $_POST['palavras_chave'] ?? '';

    if (!empty($novaPergunta) && !empty($resposta)) {
        try {
            updatePergunta($id, $novaPergunta, $resposta, $contexto);

            if (!empty($novasPalavrasChave)) {
                addPalavrasChave($id, $novasPalavrasChave);
            }

            $success = 'Pergunta atualizada com sucesso!';
        } catch (Exception $e) {
            $error = 'Erro ao atualizar a pergunta: ' . $e->getMessage();
        }
    } else {
        $error = 'Pergunta e resposta são obrigatórias.';
    }
}
?>

<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="editar.css"> <!-- CSS exclusivo para edição de perguntas -->
</head>

<div class="container">
    <h1>Editar Pergunta</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="pergunta">Pergunta *</label>
            <textarea id="pergunta" name="pergunta" rows="3" class="form-control" required><?= $pergunta['pergunta'] ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="resposta">Resposta *</label>
            <textarea id="resposta" name="resposta" rows="5" class="form-control" required><?= $pergunta['resposta'] ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="contexto">Contexto (opcional)</label>
            <textarea id="contexto" name="contexto" rows="3" class="form-control"><?= $pergunta['contexto'] ?></textarea>
            <small class="text-muted">Informações adicionais que podem ajudar o chatbot a entender melhor a pergunta.</small>
        </div>
        
        <div class="form-group">
            <label for="palavras_chave">Palavras-chave (opcional)</label>
            <input type="text" id="palavras_chave" name="palavras_chave" class="form-control" value="<?= $palavrasChaveString ?>">
            <small class="text-muted">Separe as palavras-chave por vírgula. Ex: login, acesso, senha</small>
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
        // Limpa os valores dos campos de entrada e textarea
        document.getElementById('pergunta').value = '';
        document.getElementById('resposta').value = '';
        document.getElementById('contexto').value = '';
        document.getElementById('palavras_chave').value = '';
    }
</script>

<?php include '../../includes/footer.php'; ?>
