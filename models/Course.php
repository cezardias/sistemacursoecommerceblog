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

    public function create($titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem = null)
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, descricao, preco_vista, preco_parcelado, parcelas, categoria, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem]);
    }

    public function update($id, $titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem = null)
    {
        if ($imagem) {
            $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, preco_vista = ?, preco_parcelado = ?, parcelas = ?, categoria = ?, imagem = ? WHERE id = ?";
            $params = [$titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $imagem, $id];
        } else {
            $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, preco_vista = ?, preco_parcelado = ?, parcelas = ?, categoria = ? WHERE id = ?";
            $params = [$titulo, $descricao, $preco_vista, $preco_parcelado, $parcelas, $categoria, $id];
        }
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $query = "SELECT imagem FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se quiser deletar o arquivo físico também descomente abaixo (cuidado com URLs de terceiros)
        // if ($row && $row['imagem'] && strpos($row['imagem'], 'uploads/') !== false) {
        //     @unlink($row['imagem']);
        // }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>