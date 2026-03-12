<?php
// db_fix_courses.php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
$db = (new Database())->getConnection();

if (!$db) {
    die("<h1 style='color:red'>Erro Crítico: Não foi possível conectar ao banco de dados!</h1>");
}

echo "<html><body style='font-family:sans-serif; padding:20px;'>";
echo "<h1>🔧 Atualização de Banco de Dados - Cursos</h1>";
echo "<hr>";

try {
    // 1. Verificando Tabela 'cursos'
    echo "<h3>1. Verificando Tabela 'cursos'...</h3>";

    // Garantir colunas se já existir
    $check = $db->query("SHOW COLUMNS FROM cursos LIKE 'imagem'");
    if ($check->rowCount() == 0) {
        $db->exec("ALTER TABLE cursos ADD COLUMN imagem VARCHAR(255) AFTER categoria");
        echo "<p style='color:green'>✅ Coluna 'imagem' adicionada em 'cursos'.</p>";
    }

    $check_status = $db->query("SHOW COLUMNS FROM cursos LIKE 'status'");
    if ($check_status->rowCount() == 0) {
        $db->exec("ALTER TABLE cursos ADD COLUMN status VARCHAR(20) DEFAULT 'ativo' AFTER imagem");
        echo "<p style='color:green'>✅ Coluna 'status' adicionada em 'cursos'.</p>";
    }

    echo "<hr>";
    echo "<h2 style='color:green'>✅ TUDO PRONTO!</h2>";
    echo "<p>Agora o sistema de cursos suporta upload de imagens.</p>";
    echo "<a href='index.php?url=admin' style='display:inline-block; background:navy; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Voltar ao Dashboard</a>";

} catch (PDOException $e) {
    echo "<h3 style='color:red'>❌ ERRO SQL:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}

echo "</body></html>";
?>