<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Acesso negado.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$texto = $data['texto'] ?? '';

if (empty($texto)) {
    echo json_encode(['success' => false, 'message' => 'Texto não fornecido.']);
    exit;
}

try {
    // Remove pontuações e transforma o texto em palavras únicas
    $palavras = array_unique(array_filter(explode(' ', preg_replace('/[^\w\s]/u', '', strtolower($texto)))));

    // Busca palavras-chave já existentes no banco de dados
    $stmt = $pdo->query("SELECT palavra FROM palavras_chave");
    $palavrasExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Remove palavras já existentes
    $palavrasUnicas = array_diff($palavras, $palavrasExistentes);

    echo json_encode(['success' => true, 'palavras' => implode(', ', $palavrasUnicas)]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao gerar palavras-chave: ' . $e->getMessage()]);
}
?>
