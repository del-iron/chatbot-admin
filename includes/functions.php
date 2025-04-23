<?php
// Funções úteis para o sistema

/**
 * Formata a data para exibição
 */
function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

/**
 * Busca todas as perguntas e respostas
 */
function getAllPerguntas() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM perguntas_respostas ORDER BY id DESC");
    return $stmt->fetchAll();
}

/**
 * Busca uma pergunta específica por ID
 */
function getPerguntaById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM perguntas_respostas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Busca palavras-chave associadas a uma pergunta
 */
function getPalavrasChaveByPergunta($pergunta_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM palavras_chave WHERE pergunta_id = ?");
    $stmt->execute([$pergunta_id]);
    return $stmt->fetchAll();
}

/**
 * Adiciona uma nova pergunta e resposta
 */
function addPergunta($pergunta, $resposta, $contexto) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("INSERT INTO perguntas_respostas (pergunta, resposta, contexto) VALUES (?, ?, ?)");
        $stmt->execute([$pergunta, $resposta, $contexto]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception('Erro ao inserir a pergunta no banco de dados: ' . $e->getMessage());
    }
}

/**
 * Atualiza uma pergunta existente
 */
function updatePergunta($id, $pergunta, $resposta, $contexto) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE perguntas_respostas SET pergunta = ?, resposta = ?, contexto = ? WHERE id = ?");
    return $stmt->execute([$pergunta, $resposta, $contexto, $id]);
}

/**
 * Remove uma pergunta
 */
function deletePergunta($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM perguntas_respostas WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Adiciona palavras-chave a uma pergunta
 */
function addPalavrasChave($pergunta_id, $palavras) {
    global $pdo;
    
    // Remove palavras-chave existentes
    $stmt = $pdo->prepare("DELETE FROM palavras_chave WHERE pergunta_id = ?");
    $stmt->execute([$pergunta_id]);
    
    // Adiciona as novas palavras-chave
    $palavras = array_unique(array_map('trim', explode(',', $palavras)));
    $insertStmt = $pdo->prepare("INSERT INTO palavras_chave (palavra, pergunta_id) VALUES (?, ?)");
    
    foreach ($palavras as $palavra) {
        if (!empty($palavra)) {
            $insertStmt->execute([$palavra, $pergunta_id]);
        }
    }
    
    return true;
}
?>