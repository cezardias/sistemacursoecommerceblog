<?php
require_once 'config/database.php';
$db = (new Database())->getConnection();

$banners = [
    [
        'imagem' => '/uploads/banners/banner1.jpg',
        'titulo' => 'Garantia Aula Direta',
        'link' => '/index.php?url=cursos',
        'ordem' => 1
    ],
    [
        'imagem' => '/uploads/banners/banner2.png',
        'titulo' => 'Formação de Qualidade para um Futuro de Oportunidades',
        'link' => '/index.php?url=cursos',
        'ordem' => 2
    ]
];

foreach ($banners as $b) {
    $stmt = $db->prepare("INSERT INTO banners (imagem, titulo, link, ordem, status) VALUES (?, ?, ?, ?, 'ativo')");
    $stmt->execute([$b['imagem'], $b['titulo'], $b['link'], $b['ordem']]);
}

echo "Banners iniciais inseridos com sucesso!";
unlink(__FILE__);
?>