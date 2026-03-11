<?php
// admin_setup.php
require_once 'config/database.php';
require_once 'models/User.php';

$db = (new Database())->getConnection();

$nome = "Super Admin";
$email = "admin@auladireta.com.br";
$senha = "admin123";

// Check if already exists
$check = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $db->prepare($check);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    // Update to admin just in case
    $update = "UPDATE usuarios SET nivel = 'admin', status = 'ativo' WHERE email = ?";
    $stmt_up = $db->prepare($update);
    $stmt_up->execute([$email]);
    echo "Usuário já existe. Foi atualizado para ADMIN com sucesso!<br>";
} else {
    $pass_hash = password_hash($senha, PASSWORD_DEFAULT);
    $insert = "INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (?, ?, ?, 'admin', 'ativo')";
    $stmt_in = $db->prepare($insert);
    if ($stmt_in->execute([$nome, $email, $pass_hash])) {
        echo "Usuário ADMIN criado com sucesso!<br>";
    } else {
        echo "Erro ao criar usuário.<br>";
    }
}

echo "<strong>Dados de Acesso:</strong><br>";
echo "Login: " . $email . "<br>";
echo "Senha: " . $senha . "<br><br>";
echo "<strong>AVISO: APAGUE ESTE ARQUIVO (admin_setup.php) DO SERVIDOR APÓS USAR!</strong>";
?>