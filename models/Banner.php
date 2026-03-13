<?php
// models/Banner.php

class Banner
{
    private $conn;
    private $table_name = "banners";

    public $id;
    public $imagem;
    public $titulo;
    public $link;
    public $ordem;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (imagem, titulo, link, ordem, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->imagem, $this->titulo, $this->link, $this->ordem, $this->status]);
    }

    public function getAll($only_active = false)
    {
        $query = "SELECT * FROM " . $this->table_name;
        if ($only_active) {
            $query .= " WHERE status = 'ativo'";
        }
        $query .= " ORDER BY ordem ASC, id DESC";
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

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, link = ?, ordem = ?, status = ? WHERE id = ?";
        $params = [$this->titulo, $this->link, $this->ordem, $this->status, $this->id];

        if ($this->imagem) {
            $query = "UPDATE " . $this->table_name . " SET imagem = ?, titulo = ?, link = ?, ordem = ?, status = ? WHERE id = ?";
            $params = [$this->imagem, $this->titulo, $this->link, $this->ordem, $this->status, $this->id];
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
}
?>