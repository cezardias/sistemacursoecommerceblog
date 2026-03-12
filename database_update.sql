-- SQL Script to update database for Course Management
-- Run this in your phpMyAdmin SQL tab

-- 1. Ensure the 'imagem' column exists
ALTER TABLE cursos ADD COLUMN IF NOT EXISTS imagem VARCHAR(255) AFTER categoria;

-- 2. Ensure the 'status' column exists
ALTER TABLE cursos ADD COLUMN IF NOT EXISTS status VARCHAR(20) DEFAULT 'ativo' AFTER imagem;

-- 3. Verify columns (Optional)
-- DESCRIBE cursos;
