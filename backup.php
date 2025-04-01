<?php
$source = __DIR__; // Diretório atual (chatbot-admin)
$backupDir = __DIR__ . '/../backups/chatbot-admin-backup-' . date('Y-m-d_H-i-s');

// Função para copiar recursivamente
function recursiveCopy($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }

    foreach (scandir($source) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $srcFile = $source . DIRECTORY_SEPARATOR . $file;
        $destFile = $destination . DIRECTORY_SEPARATOR . $file;

        if (is_dir($srcFile)) {
            recursiveCopy($srcFile, $destFile);
        } else {
            copy($srcFile, $destFile);
        }
    }
}

// Executa o backup
try {
    recursiveCopy($source, $backupDir);
    echo "Backup concluído com sucesso em: $backupDir";
} catch (Exception $e) {
    echo "Erro ao realizar o backup: " . $e->getMessage();
}
?>
