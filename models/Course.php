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

    public function getAll($only_active = false, $limit = null)
    {
        $query = "SELECT * FROM " . $this->table_name;
        if ($only_active) {
            $query .= " WHERE status = 'ativo'";
        }
        $query .= " ORDER BY id DESC";

        if ($limit) {
            $query .= " LIMIT " . (int) $limit;
        }

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

    public function create($titulo, $description, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem = null, $status = 'ativo')
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, descricao, preco_vista, preco_parcelado, parcelas, categoria, imagem, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titulo, $description, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem, $status]);
    }

    public function update($id, $titulo, $description, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem = null, $status = 'ativo')
    {
        if ($imagem) {
            $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, preco_vista = ?, preco_parcelado = ?, parcelas = ?, categoria = ?, imagem = ?, status = ? WHERE id = ?";
            $params = [$titulo, $description, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem, $status, $id];
        } else {
            $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, preco_vista = ?, preco_parcelado = ?, parcelas = ?, categoria = ?, status = ? WHERE id = ?";
            $params = [$titulo, $description, $preco_vista, $preco_parcelado, $parcelas, $categoria, $status, $id];
        }
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function toggleStatus($id)
    {
        $query = "UPDATE " . $this->table_name . " SET status = IF(status = 'ativo', 'inativo', 'ativo') WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>