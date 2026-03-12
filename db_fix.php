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
    // 1. Verificar se a tabela existe
    $db->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        conteudo TEXT NOT NULL,
        autor_id INT NOT NULL,
        imagem VARCHAR(255),
        status VARCHAR(20) DEFAULT 'publicado',
        categoria VARCHAR(50) DEFAULT 'Geral',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "ℹ️ Tabela 'blog_posts' verificada/criada.<br>";

    // 2. Garantir colunas específicas se a tabela já existia mas estava incompleta
    $columns_to_check = [
        'status' => "ALTER TABLE blog_posts ADD COLUMN status VARCHAR(20) DEFAULT 'publicado' AFTER imagem",
        'categoria' => "ALTER TABLE blog_posts ADD COLUMN categoria VARCHAR(50) DEFAULT 'Geral' AFTER status"
    ];

    foreach ($columns_to_check as $col => $sql) {
        $check = $db->query("SHOW COLUMNS FROM blog_posts LIKE '$col'");
        if ($check->rowCount() == 0) {
            $db->exec($sql);
            echo "✅ Coluna '$col' adicionada em 'blog_posts'.<br>";
        } else {
            echo "ℹ️ Coluna '$col' já existe em 'blog_posts'.<br>";
        }
    }

    // 2.3 Mostrar estrutura final para confirmação
    echo "<h4>Estrutura atual da tabela 'blog_posts':</h4>";
    $cols = $db->query("DESCRIBE blog_posts");
    echo "<ul>";
    while ($c = $cols->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . $c['Field'] . " (" . $c['Type'] . ")</li>";
    }
    echo "</ul>";

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