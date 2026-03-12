-- SQL Script to update database for Course Management
-- Standard MySQL version (without IF NOT EXISTS for columns)
-- If the columns already exist, these commands will return an error, which you can ignore.

-- 1. Add 'imagem' column
ALTER TABLE cursos ADD COLUMN imagem VARCHAR(255) AFTER categoria;

-- 2. Add 'status' column
ALTER TABLE cursos ADD COLUMN status VARCHAR(20) DEFAULT 'ativo' AFTER imagem;
