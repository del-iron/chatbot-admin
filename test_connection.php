<?php
require_once 'includes/config.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
    echo "Conexão bem-sucedida! Tabelas no banco de dados:<br>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Tables_in_chatbot'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
