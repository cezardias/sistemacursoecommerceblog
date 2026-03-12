<?php
// db_fix.php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
$db = (new Database())->getConnection();

if (!$db) {
    die("<h1 style='color:red'>Erro Crítico: Não foi possível conectar ao banco de dados!</h1>");
}

echo "<html><body style='font-family:sans-serif; padding:20px;'>";
echo "<h1>🔧 Reparador de Banco de Dados - Aula Direta</h1>";
echo "<hr>";

try {
    // 1. USUARIOS
    echo "<h3>1. Verificando Tabela 'usuarios'...</h3>";
    $db->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nivel VARCHAR(20) DEFAULT 'cliente',
        status VARCHAR(20) DEFAULT 'ativo',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Garantir colunas se já existir
    $cols_user = [
        'status' => "ALTER TABLE usuarios ADD COLUMN status VARCHAR(20) DEFAULT 'ativo' AFTER nivel",
        'nivel' => "ALTER TABLE usuarios ADD COLUMN nivel VARCHAR(20) DEFAULT 'cliente' AFTER senha"
    ];
    foreach ($cols_user as $c => $sql) {
        $check = $db->query("SHOW COLUMNS FROM usuarios LIKE '$c'");
        if ($check->rowCount() == 0) {
            $db->exec($sql);
            echo "<p style='color:green'>✅ Coluna '$c' adicionada em 'usuarios'.</p>";
        } else {
            echo "<p style='color:blue'>ℹ️ Coluna '$c' já existe em 'usuarios'.</p>";
        }
    }

    // 2. BLOG_POSTS
    echo "<h3>2. Verificando Tabela 'blog_posts'...</h3>";
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

    $cols_blog = [
        'status' => "ALTER TABLE blog_posts ADD COLUMN status VARCHAR(20) DEFAULT 'publicado' AFTER imagem",
        'categoria' => "ALTER TABLE blog_posts ADD COLUMN categoria VARCHAR(50) DEFAULT 'Geral' AFTER status"
    ];
    foreach ($cols_blog as $c => $sql) {
        $check = $db->query("SHOW COLUMNS FROM blog_posts LIKE '$c'");
        if ($check->rowCount() == 0) {
            $db->exec($sql);
            echo "<p style='color:green'>✅ Coluna '$c' adicionada em 'blog_posts'.</p>";
        } else {
            echo "<p style='color:blue'>ℹ️ Coluna '$c' já existe em 'blog_posts'.</p>";
        }
    }

    // 3. ADMIN RESET
    echo "<h3>3. Resetando Super Admin...</h3>";
    $email = 'admin@auladireta.com.br';
    $senha = password_hash('admin123', PASSWORD_DEFAULT);
    $db->prepare("DELETE FROM usuarios WHERE email = ?")->execute([$email]);
    $sql = "INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (?, ?, ?, 'admin', 'ativo')";
    $db->prepare($sql)->execute(['Super Admin', $email, $senha]);
    echo "<p style='color:green'>✅ Admin 'admin@auladireta.com.br' pronto (Senha: admin123).</p>";

    echo "<hr>";
    echo "<h2 style='color:green'>✅ TUDO PRONTO!</h2>";
    echo "<p>Agora você já pode salvar no blog. Vá para:</p>";
    echo "<a href='index.php?url=admin&view=blog_form' style='display:inline-block; background:navy; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Ir para o Formulário do Blog</a>";

} catch (PDOException $e) {
    echo "<h3 style='color:red'>❌ ERRO SQL:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<h4>Se o erro persistir, execute este comando no phpMyAdmin:</h4>";
    echo "<textarea style='width:100%; height:100px;'>ALTER TABLE blog_posts ADD COLUMN status VARCHAR(20) DEFAULT 'publicado' AFTER imagem;
ALTER TABLE blog_posts ADD COLUMN categoria VARCHAR(50) DEFAULT 'Geral' AFTER status;</textarea>";
}

echo "</body></html>";
?>