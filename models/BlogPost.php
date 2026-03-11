<?php
// models/BlogPost.php

class BlogPost
{
    private $conn;
    private $table_name = "blog_posts";

    public $id;
    public $titulo;
    public $slug;
    public $conteudo;
    public $autor_id;
    public $imagem;
    public $status;
    public $categoria;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, slug, conteudo, autor_id, imagem, status, categoria) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->titulo, $this->slug, $this->conteudo, $this->autor_id, $this->imagem, $this->status, $this->categoria]);
    }

    public function readAll($published_only = false)
    {
        $query = "SELECT p.*, u.nome as autor_nome FROM " . $this->table_name . " p 
                  JOIN usuarios u ON p.autor_id = u.id";
        if ($published_only) {
            $query .= " WHERE p.status = 'publicado'";
        }
        $query .= " ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOneBySlug($slug)
    {
        $query = "SELECT p.*, u.nome as autor_nome FROM " . $this->table_name . " p 
                  JOIN usuarios u ON p.autor_id = u.id 
                  WHERE p.slug = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, slug = ?, conteudo = ?, imagem = ?, status = ?, categoria = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->titulo, $this->slug, $this->conteudo, $this->imagem, $this->status, $this->categoria, $this->id]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>