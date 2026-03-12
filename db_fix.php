<?php
// db_fix.php
require_once 'config/database.php';
$db = (new Database())->getConnection();

if (!$db) {
    die("Erro ao conectar ao banco de dados!");
}

echo "<h1>Limpando e Consertando o Banco de Dados</h1>";

try {
    // 1. Adicionar coluna 'status' se não existir
    $check_status = $db->query("SHOW COLUMNS FROM usuarios LIKE 'status'");
    if ($check_status->rowCount() == 0) {
        $db->exec("ALTER TABLE usuarios ADD COLUMN status VARCHAR(20) DEFAULT 'ativo' AFTER nivel");
        echo "✅ Coluna 'status' adicionada.<br>";
    } else {
        echo "ℹ️ Coluna 'status' já existe.<br>";
    }

    // 2. Adicionar coluna 'nivel' se não existir (por precaução)
    $check_nivel = $db->query("SHOW COLUMNS FROM usuarios LIKE 'nivel'");
    if ($check_nivel->rowCount() == 0) {
        $db->exec("ALTER TABLE usuarios ADD COLUMN nivel VARCHAR(20) DEFAULT 'cliente' AFTER senha");
        echo "✅ Coluna 'nivel' adicionada.<br>";
    } else {
        echo "ℹ️ Coluna 'nivel' já existe.<br>";
    }

    // 3. Garantir que o Admin existe e tem tudo certo
    $email = 'admin@auladireta.com.br';
    $senha = password_hash('admin123', PASSWORD_DEFAULT);

    // Primeiro remove para garantir que não haja duplicidade ou lixo
    $db->prepare("DELETE FROM usuarios WHERE email = ?")->execute([$email]);

    $sql = "INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (?, ?, ?, 'admin', 'ativo')";
    $stmt = $db->prepare($sql);
    if ($stmt->execute(['Super Admin', $email, $senha])) {
        echo "✅ Usuário Admin resetado com sucesso! (Senha: admin123)<br>";
    }

    echo "<h3>Tudo pronto!</h3>";
    echo "<p>Agora tente logar em: <a href='index.php?url=login'>Página de Login</a></p>";
    echo "<p><strong>IMPORTANTE: Deletar este arquivo (db_fix.php) após o uso.</strong></p>";

} catch (PDOException $e) {
    echo "❌ Erro ao processar: " . $e->getMessage();
}
?>