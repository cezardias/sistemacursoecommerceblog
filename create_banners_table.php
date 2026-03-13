<?php
// create_banners_table.php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();

    $query = "CREATE TABLE IF NOT EXISTS banners (
        id INT AUTO_INCREMENT PRIMARY KEY,
        imagem VARCHAR(255) NOT NULL,
        titulo VARCHAR(255),
        link VARCHAR(255),
        ordem INT DEFAULT 0,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";

    $db->exec($query);
    echo "Tabela 'banners' criada com sucesso!<br>";

    // Create uploads/banners directory if it doesn't exist
    if (!file_exists('uploads/banners')) {
        mkdir('uploads/banners', 0777, true);
        echo "Diretório 'uploads/banners' criado.<br>";
    }

    echo "Configuração concluída.";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>