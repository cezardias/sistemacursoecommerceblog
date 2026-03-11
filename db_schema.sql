-- AUTO-GENERATED SCHEMA FOR AULA DIRETA
-- COMPATIBLE WITH HOSTGATOR PHPMYADMIN

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `nivel` ENUM('cliente', 'admin') DEFAULT 'cliente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `cursos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco_vista` DECIMAL(10, 2) NOT NULL,
    `preco_parcelado` DECIMAL(10, 2),
    `parcelas` INT DEFAULT 10,
    `imagem` VARCHAR(255),
    `categoria` VARCHAR(50),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `pedidos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `total` DECIMAL(10, 2) NOT NULL,
    `status` ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `pedido_itens` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pedido_id` INT NOT NULL,
    `curso_id` INT NOT NULL,
    `preco_unitario` DECIMAL(10, 2) NOT NULL,
    CONSTRAINT `fk_itens_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_itens_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `conteudo` TEXT NOT NULL,
    `autor_id` INT NOT NULL,
    `imagem` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_blog_autor` FOREIGN KEY (`autor_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `comentarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `post_id` INT NOT NULL,
    `usuario_id` INT NOT NULL,
    `comentario` TEXT NOT NULL,
    `status` ENUM('pendente', 'aprovado') DEFAULT 'pendente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_comentario_post` FOREIGN KEY (`post_id`) REFERENCES `blog_posts`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `usuarios` (`nome`, `email`, `senha`, `nivel`) VALUES 
('Super Admin', 'admin', '$2y$10$T8VqU.D9Y.9w.U8wX5Vv9eN6S2g5f3R8h5H8M5v5k5r5S5t5u5v5w', 'admin');

INSERT INTO `cursos` (`titulo`, `descricao`, `preco_vista`, `preco_parcelado`, `parcelas`, `categoria`) VALUES 
('Pós-Graduação Gestão', 'O próximo passo da sua carreira começa aqui.', 1199.00, 149.99, 10, 'Pós-Graduação'),
('Avaliador de Imóveis (COFECI)', 'Curso completo para registro no COFECI.', 999.00, 129.00, 10, 'Técnico'),
('Cursos Técnicos', 'Habilidades práticas com foco no mercado.', 999.00, 127.90, 10, 'Técnico'),
('EJA', 'Transforme sua história por meio da educação.', 899.00, NULL, 1, 'EJA');

COMMIT;
