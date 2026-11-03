-- ========================================================
-- BANCO DE DADOS: Resenha ou Ódio
-- Stack: PHP + MySQL (PDO) + Tailwind CSS
-- ========================================================

CREATE DATABASE IF NOT EXISTS `resenha_ou_odio` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `resenha_ou_odio`;

-- --------------------------------------------------------
-- Tabela: usuarios
-- Tratar senhas de usuários com hash bcrypt
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL COMMENT 'Hash gerado via password_hash() com PASSWORD_BCRYPT',
    `avatar` VARCHAR(255) DEFAULT 'default_avatar.png',
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: jogadas
-- Registra cada lançamento de moeda (50% probabilidade)
-- Cara = Resenha; Coroa = Ódio
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `jogadas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NULL,
    `resultado` ENUM('resenha', 'odio') NOT NULL,
    `face` ENUM('cara', 'coroa') NOT NULL,
    `probabilidade` DECIMAL(5,2) DEFAULT 50.00,
    `ip` VARCHAR(45) NOT NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL,
    INDEX `idx_resultado` (`resultado`),
    INDEX `idx_criado_em` (`criado_em`),
    INDEX `idx_usuario_jogada` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: logs_auditoria
-- Registra todas as alterações e ações no sistema
-- para auditorias futuras (segurança e conformidade)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `logs_auditoria` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NULL,
    `usuario_nome` VARCHAR(100) NULL,
    `acao` VARCHAR(60) NOT NULL COMMENT 'Ex: CADASTRO, LOGIN, LOGOUT, JOGADA, ALTERACAO_PERFIL, etc.',
    `descricao` TEXT NOT NULL,
    `ip` VARCHAR(45) NOT NULL,
    `user_agent` VARCHAR(255) NOT NULL,
    `detalhes_json` TEXT NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE SET NULL,
    INDEX `idx_acao` (`acao`),
    INDEX `idx_usuario_auditoria` (`usuario_id`),
    INDEX `idx_criado_em_auditoria` (`criado_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dados Iniciais de Demonstração (Opcionais)
-- Senha do usuário demo: admin123 (hash bcrypt)
-- --------------------------------------------------------
INSERT IGNORE INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES 
(1, 'Administrador Resenha', 'admin@resenha.com', '$2y$10$tZ2yY3w9i1FmU5a7vGkFfej3gV7mJkWuV7e0pZ7YfN1C7v9aDq92.');

-- Inserção do log de criação da base
INSERT INTO `logs_auditoria` (`usuario_id`, `usuario_nome`, `acao`, `descricao`, `ip`, `user_agent`) VALUES 
(1, 'Administrador Resenha', 'SISTEMA_INSTALADO', 'Banco de dados e tabelas do sistema Resenha ou Ódio inicializados com sucesso.', '127.0.0.1', 'Database Installer');
