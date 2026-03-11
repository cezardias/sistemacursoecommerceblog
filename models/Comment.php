<?php
// models/Comment.php

class Comment
{
    private $conn;
    private $table_name = "comentarios";

    public $id;
    public $post_id;
    public $usuario_id;
    public $comentario;
    public $resposta_admin;
    public $status;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (post_id, usuario_id, comentario) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->post_id, $this->usuario_id, $this->comentario]);
    }

    public function readByPost($post_id, $approved_only = true)
    {
        $query = "SELECT c.*, u.nome as usuario_nome FROM " . $this->table_name . " c 
                  JOIN usuarios u ON c.usuario_id = u.id 
                  WHERE c.post_id = ?";
        if ($approved_only) {
            $query .= " AND c.status = 'aprovado'";
        }
        $query .= " ORDER BY c.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$post_id]);
        return $stmt;
    }

    public function readAll()
    {
        $query = "SELECT c.*, u.nome as usuario_nome, p.titulo as post_titulo FROM " . $this->table_name . " c 
                  JOIN usuarios u ON c.usuario_id = u.id 
                  JOIN blog_posts p ON c.post_id = p.id 
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id]);
    }

    public function reply($id, $resposta)
    {
        $query = "UPDATE " . $this->table_name . " SET resposta_admin = ?, status = 'aprovado' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$resposta, $id]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>