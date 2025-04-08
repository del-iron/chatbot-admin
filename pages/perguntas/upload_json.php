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

$pageTitle = "Upload de JSON";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['json_file']) && $_FILES['json_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['json_file']['tmp_name'];
        $fileContents = file_get_contents($fileTmpPath);

        try {
            $data = json_decode($fileContents, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('O arquivo JSON é inválido.');
            }

            foreach ($data as $item) {
                $pergunta = $item['pergunta'] ?? '';
                $resposta = $item['resposta'] ?? '';
                $contexto = $item['contexto'] ?? '';
                $palavrasChave = $item['palavras_chave'] ?? '';

                if (!empty($pergunta) && !empty($resposta)) {
                    $perguntaId = addPergunta($pergunta, $resposta, $contexto);

                    if (!empty($palavrasChave)) {
                        addPalavrasChave($perguntaId, $palavrasChave);
                    }
                }
            }

            $success = 'Dados importados com sucesso!';
        } catch (Exception $e) {
            $error = 'Erro ao processar o arquivo JSON: ' . $e->getMessage();
        }
    } else {
        $error = 'Erro ao fazer upload do arquivo.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="upload_json.css"> <!-- CSS exclusivo para upload de JSON -->
</head>
<body>
<div class="container">
    <h1>Upload de JSON</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="json_file">Selecione o arquivo JSON</label>
            <input type="file" id="json_file" name="json_file" class="form-control" accept=".json" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Importar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>
</body>
</html>
