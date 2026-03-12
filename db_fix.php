<?php
// db_fix.php
require_once 'config/database.php';
$db = (new Database())->getConnection();

if (!$db) {
    die("Erro ao conectar ao banco de dados!");
}

echo "<h1>Limpando e Consertando o Banco de Dados</h1>";

try {
    // --- FIX USUARIOS ---
    // 1. Adicionar coluna 'status' se não existir
    $check_status = $db->query("SHOW COLUMNS FROM usuarios LIKE 'status'");
    if ($check_status->rowCount() == 0) {
        $db->exec("ALTER TABLE usuarios ADD COLUMN status VARCHAR(20) DEFAULT 'ativo' AFTER nivel");
        echo "✅ Coluna 'status' adicionada em 'usuarios'.<br>";
    }

    // --- FIX BLOG_POSTS ---
    // 1. Adicionar coluna 'status' se não existir
    $check_blog_status = $db->query("SHOW COLUMNS FROM blog_posts LIKE 'status'");
    if ($check_blog_status->rowCount() == 0) {
        $db->exec("ALTER TABLE blog_posts ADD COLUMN status VARCHAR(20) DEFAULT 'publicado' AFTER imagem");
        echo "✅ Coluna 'status' adicionada em 'blog_posts'.<br>";
    }

    // 2. Adicionar coluna 'categoria' se não existir
    $check_blog_cat = $db->query("SHOW COLUMNS FROM blog_posts LIKE 'categoria'");
    if ($check_blog_cat->rowCount() == 0) {
        $db->exec("ALTER TABLE blog_posts ADD COLUMN categoria VARCHAR(50) DEFAULT 'Geral' AFTER status");
        echo "✅ Coluna 'categoria' adicionada em 'blog_posts'.<br>";
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