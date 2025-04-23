<?php
require_once 'includes/db.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
    echo "Conexão bem-sucedida! Tabelas no banco de dados:<br>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Tables_in_chatbot_moodle'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
