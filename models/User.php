<?php
// models/User.php
require_once 'config/database.php';

class User
{
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $nivel;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($email, $password)
    {
        $query = "SELECT id, nome, email, senha, nivel FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['senha'])) {
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->email = $row['email'];
                $this->nivel = $row['nivel'];
                return true;
            }
        }
        return false;
    }

    public function register($nome, $email, $senha)
    {
        // Check if email already exists
        $check = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt_check = $this->conn->prepare($check);
        $stmt_check->execute([$email]);
        if ($stmt_check->rowCount() > 0)
            return false;

        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        return $stmt->execute([$nome, $email, $hashed_password]);
    }
}
?>