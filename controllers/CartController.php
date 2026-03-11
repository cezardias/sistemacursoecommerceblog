<?php
// controllers/CartController.php

class CartController
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add($course_id, $price, $title)
    {
        $_SESSION['cart'][$course_id] = [
            'id' => $course_id,
            'title' => $title,
            'price' => $price,
            'qty' => 1
        ];
    }

    public function remove($course_id)
    {
        unset($_SESSION['cart'][$course_id]);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'];
        }
        return $total;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }

    public function checkoutSimulation($db, $user_id)
    {
        if (empty($_SESSION['cart']))
            return false;

        try {
            $db->beginTransaction();

            $total = $this->getTotal();
            $query = "INSERT INTO pedidos (usuario_id, total, status) VALUES (?, ?, 'pago')";
            $stmt = $db->prepare($query);
            $stmt->execute([$user_id, $total]);
            $pedido_id = $db->lastInsertId();

            foreach ($_SESSION['cart'] as $item) {
                $query_item = "INSERT INTO pedido_itens (pedido_id, curso_id, preco_unitario) VALUES (?, ?, ?)";
                $stmt_item = $db->prepare($query_item);
                $stmt_item->execute([$pedido_id, $item['id'], $item['price']]);
            }

            $db->commit();
            $this->clear();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
}
?>