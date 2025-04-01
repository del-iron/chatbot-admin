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

$pageTitle = "Lista de Palavras-chave";
?>
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="style.css"> <!-- CSS exclusivo para palavras-chave -->
</head>

<?php
$palavrasChave = $pdo->query("SELECT * FROM palavras_chave ORDER BY id DESC")->fetchAll();
?>

<div class="container">
    <h1>Lista de Palavras-chave</h1>
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
                <td><?= $palavra['id'] ?></td>
                <td><?= $palavra['palavra'] ?></td>
                <td><?= $palavra['pergunta_id'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $palavra['id'] ?>" class="btn btn-sm btn-info" target="_blank">Editar</a>
                    <form method="POST" action="remover.php" style="display:inline;" target="_blank">
                        <input type="hidden" name="id" value="<?= $palavra['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover esta palavra-chave?')">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
