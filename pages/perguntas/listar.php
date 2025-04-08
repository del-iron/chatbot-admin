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

$pageTitle = "Lista de Perguntas";
?>
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="listar.css"> <!-- CSS exclusivo para listar perguntas -->
</head>

<?php
$perguntas = getAllPerguntas(); // Função já definida em includes/functions.php
?>

<div class="container">
    <h1>Lista de Perguntas</h1>
    <div class="actions">
        <!-- Botão para adicionar nova pergunta -->
        <a href="adicionar.php" class="btn btn-primary" onclick="abrirNovaAba('adicionar.php')">Adicionar Nova Pergunta</a>
        <!-- Botão para upload de JSON -->
        <a href="upload_json.php" class="btn btn-secondary" onclick="abrirNovaAba('upload_json.php')">Upload de JSON</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Resposta</th>
                <th>Contexto</th>
                <th>Palavras-chave</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($perguntas as $pergunta): ?>
            <tr>
                <td><?= $pergunta['id'] ?></td>
                <td><?= substr($pergunta['pergunta'], 0, 50) ?>...</td>
                <td><?= substr($pergunta['resposta'], 0, 50) ?>...</td>
                <td><?= $pergunta['contexto'] ?? 'N/A' ?></td>
                <td>
                    <?php
                    $palavrasChave = getPalavrasChaveByPergunta($pergunta['id']);
                    if (!empty($palavrasChave)) {
                        echo implode(', ', array_column($palavrasChave, 'palavra'));
                    } else {
                        echo 'Nenhuma';
                    }
                    ?>
                </td>
                <td>
                    <a href="editar.php?id=<?= $pergunta['id'] ?>" class="btn btn-sm btn-info" target="_blank" rel="noopener noreferrer">Editar</a>
                    <form method="POST" action="remover.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $pergunta['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover esta pergunta?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function abrirNovaAba(url) {
        window.open(url, '_blank');
    }
</script>

<?php include '../../includes/footer.php'; ?>