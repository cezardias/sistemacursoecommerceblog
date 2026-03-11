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
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($email, $password)
    {
        $query = "SELECT id, nome, email, senha, nivel, status FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['senha'])) {
                if ($row['status'] == 'bloqueado') {
                    return "Sua conta está bloqueada. Entre em contato com o suporte.";
                }
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->email = $row['email'];
                $this->nivel = $row['nivel'];
                $this->status = $row['status'];
                return $row; // Return row data for session storage
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

        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, status) VALUES (?, ?, ?, 'ativo')";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        return $stmt->execute([$nome, $email, $hashed_password]);
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id]);
    }
}
?>