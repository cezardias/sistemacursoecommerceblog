<?php
// fix_comments.php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();

    // Check if column exists
    $stmt = $db->query("SHOW COLUMNS FROM comentarios LIKE 'resposta_admin'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE comentarios ADD COLUMN resposta_admin TEXT AFTER comentario");
        echo "Coluna 'resposta_admin' adicionada com sucesso!<br>";
    } else {
        echo "A coluna 'resposta_admin' já existe.<br>";
    }

    echo "Banco de dados atualizado.";
} catch (PDOException $e) {
    echo "Erro ao atualizar banco de dados: " . $e->getMessage();
}
?>