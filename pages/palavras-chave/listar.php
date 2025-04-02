<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

// Inicia a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login
if (!isLoggedIn()) {
    redirect('../../login.php');
}

// Define o título da página
$pageTitle = "Lista de Palavras-chave";

// Busca todas as palavras-chave do banco de dados
$palavrasChave = $pdo->query("SELECT * FROM palavras_chave ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="style.css"> <!-- Inclui o CSS exclusivo para palavras-chave -->
</head>
<body>
<div class="container">
    <h1>Lista de Palavras-chave</h1>
    <!-- Botão para adicionar uma nova palavra-chave -->
    <a href="adicionar.php" class="btn btn-primary">Adicionar Nova Palavra-chave</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Palavra</th>
                <th>Pergunta Associada</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($palavrasChave as $palavra): ?>
            <tr>
                <!-- Exibe o ID da palavra-chave -->
                <td><?= $palavra['id'] ?></td>
                <!-- Exibe a palavra-chave -->
                <td><?= $palavra['palavra'] ?></td>
                <!-- Exibe o ID da pergunta associada -->
                <td><?= $palavra['pergunta_id'] ?></td>
                <td>
                    <!-- Botão para editar a palavra-chave -->
                    <a href="editar.php?id=<?= $palavra['id'] ?>" class="btn btn-sm btn-info" target="_blank">Editar</a>
                    <!-- Botão para remover a palavra-chave -->
                    <form method="POST" action="remover.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $palavra['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover esta palavra-chave?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../../includes/footer.php'; // Inclui o rodapé padrão ?>
</body>
</html>
