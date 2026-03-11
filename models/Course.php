<?php
// models/Course.php
require_once 'config/database.php';

class Course
{
    private $conn;
    private $table_name = "cursos";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria)
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, descricao, preco_vista, preco_parcelado, parcelas, categoria) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria]);
    }
}
?>