<?php
// fix_admin.php
require_once 'config/database.php';
$db = (new Database())->getConnection();

if (!$db) {
    die("Erro ao conectar ao banco de dados!");
}

$email = 'admin@auladireta.com.br';
$nova_senha = 'admin123';
$hash = password_hash($nova_senha, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios SET senha = ?, nivel = 'admin', status = 'ativo' WHERE email = ?";
$stmt = $db->prepare($sql);

if ($stmt->execute([$hash, $email])) {
    if ($stmt->rowCount() > 0) {
        echo "<h1>Sucesso!</h1>";
        echo "A senha do usuário <strong>$email</strong> foi atualizada para <strong>$nova_senha</strong> usando o motor do seu servidor.<br>";
    } else {
        echo "<h1>Aviso</h1>";
        echo "O usuário <strong>$email</strong> não foi encontrado ou a senha já era essa. <br>";
        echo "Tentando criar o usuário agora...<br>";

        $sql_insert = "INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (?, ?, ?, 'admin', 'ativo')";
        $stmt_in = $db->prepare($sql_insert);
        if ($stmt_in->execute(['Super Admin', $email, $hash])) {
            echo "Usuário criado com sucesso!<br>";
        }
    }
    echo "<br><a href='index.php?url=login'>Ir para o Login</a>";
} else {
    echo "Erro ao executar o comando SQL.";
}

echo "<br><br><strong>APAGUE ESTE ARQUIVO APÓS O USO!</strong>";
?>