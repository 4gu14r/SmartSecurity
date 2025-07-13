-- Migração para modernizar o banco de dados SmartSecurity
-- Versão: 003
-- Descrição: Adiciona usuário Super Admin para desenvolvedores.
-- Data: 2025-07-12

-- =================================================================
-- ESTRUTURA INICIAL
-- =================================================================

CREATE DATABASE IF NOT EXISTS `smartsecurity`;
USE `smartsecurity`;

-- =================================================================
-- CRIAÇÃO DAS TABELAS
-- =================================================================

-- Tabela de perfis de usuário (Admin, Usuário Comum, etc.)
CREATE TABLE IF NOT EXISTS `perfil` (
  `cod` INT AUTO_INCREMENT PRIMARY KEY,
  `perfil` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `sobrenome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL COMMENT 'Armazena o hash da senha (ex: Bcrypt, Argon2)',
  `cpf_hash` CHAR(64) UNIQUE NOT NULL COMMENT 'HMAC-SHA256 do CPF para evitar duplicidade (LGPD)',
  `dt_nascimento` DATE NULL,
  `sexo` ENUM('M', 'F', 'O') NULL COMMENT 'Masculino, Feminino, Outro',
  `endereco` TEXT NULL,
  `perfil_cod` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`perfil_cod`) REFERENCES `perfil`(`cod`),
  INDEX `idx_email` (`email`),
  INDEX `idx_cpf_hash` (`cpf_hash`),
  FULLTEXT `idx_fulltext_nome_sobrenome` (`nome`, `sobrenome`)
);

-- Tabela de ocorrências (assaltos, perdas, etc.)
CREATE TABLE IF NOT EXISTS `ocorrencia` (
  `cod` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `tipo` VARCHAR(100) NOT NULL,
  `titulo_registro` VARCHAR(255) NOT NULL,
  `descricao` TEXT NOT NULL,
  `localizacao` VARCHAR(255) NULL,
  `latitude` DECIMAL(10, 8) NULL,
  `longitude` DECIMAL(11, 8) NULL,
  `dt_registro` DATETIME NOT NULL,
  `status` ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
  `images` JSON NULL COMMENT 'JSON array de caminhos de imagens',
  `views_count` INT DEFAULT 0,
  `rating` DECIMAL(3, 2) DEFAULT 0.00,
  `rating_count` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_tipo` (`tipo`),
  INDEX `idx_status` (`status`),
  INDEX `idx_dt_registro` (`dt_registro`),
  INDEX `idx_coordinates` (`latitude`, `longitude`),
  FULLTEXT `idx_fulltext_titulo_descricao` (`titulo_registro`, `descricao`)
);

-- Tabela de celulares vinculados aos usuários
CREATE TABLE IF NOT EXISTS `celular` (
  `cod` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `imei` VARCHAR(20) NOT NULL,
  `image` VARCHAR(255) NULL,
  `status` ENUM('active', 'lost', 'found', 'stolen') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_imei` (`imei`)
);

-- Tabela de comentários nas ocorrências
CREATE TABLE IF NOT EXISTS `comentario` (
  `cod` INT AUTO_INCREMENT PRIMARY KEY,
  `ocorrencia_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `parent_id` INT NULL COMMENT 'Para respostas a outros comentários',
  `texto` TEXT NOT NULL,
  `status` ENUM('active', 'hidden', 'deleted') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`ocorrencia_id`) REFERENCES `ocorrencia`(`cod`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`parent_id`) REFERENCES `comentario`(`cod`) ON DELETE CASCADE,
  INDEX `idx_ocorrencia_id` (`ocorrencia_id`),
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_parent_id` (`parent_id`)
);

-- Tabela de avaliações (ratings) para ocorrências
CREATE TABLE IF NOT EXISTS `ocorrencia_rating` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ocorrencia_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `rating` TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_user_occurrence` (`ocorrencia_id`, `usuario_id`),
  FOREIGN KEY (`ocorrencia_id`) REFERENCES `ocorrencia`(`cod`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE CASCADE
);

-- Tabela de notificações para usuários
CREATE TABLE IF NOT EXISTS `notificacoes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `mensagem` TEXT NOT NULL,
  `tipo` ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
  `lida` BOOLEAN DEFAULT FALSE,
  `url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_lida` (`lida`)
);

-- Tabela de logs de atividade do sistema
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NULL COMMENT 'NULL se a ação for do sistema',
  `action` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id`) ON DELETE SET NULL,
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_action` (`action`)
);

-- Tabela de configurações gerais do sistema
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- =================================================================
-- VIEWS OTIMIZADAS
-- =================================================================

-- View otimizada para estatísticas do dashboard
CREATE OR REPLACE VIEW `v_dashboard_stats` AS
SELECT 
    COUNT(*) AS total_occurrences,
    COUNT(CASE WHEN o.tipo = 'Assalto' THEN 1 END) AS total_assaults,
    COUNT(CASE WHEN o.tipo = 'Perda' THEN 1 END) AS total_losses,
    COUNT(CASE WHEN DATE(o.dt_registro) = CURDATE() THEN 1 END) AS today_occurrences,
    COUNT(CASE WHEN o.dt_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) AS week_occurrences,
    COUNT(CASE WHEN o.dt_registro >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) AS month_occurrences,
    (SELECT COUNT(*) FROM `usuario`) AS total_users,
    (SELECT COUNT(*) FROM `usuario` WHERE `perfil_cod` = 1) AS admin_users,
    (SELECT COUNT(*) FROM `usuario` WHERE `perfil_cod` = 2) AS regular_users
FROM `ocorrencia` o;

-- View para combinar dados de ocorrências e usuários
CREATE OR REPLACE VIEW `v_occurrences_with_user` AS
SELECT 
    o.*,
    u.nome,
    u.sobrenome,
    u.email,
    p.perfil,
    CONCAT(u.nome, ' ', u.sobrenome) AS user_full_name
FROM `ocorrencia` o
LEFT JOIN `usuario` u ON o.usuario_id = u.id
LEFT JOIN `perfil` p ON u.perfil_cod = p.cod;


-- =================================================================
-- TRIGGERS (GATILHOS)
-- =================================================================

DELIMITER $$

-- Gatilho para atualizar a média de rating após INSERIR uma nova avaliação
CREATE TRIGGER `trg_after_rating_insert`
AFTER INSERT ON `ocorrencia_rating`
FOR EACH ROW
BEGIN
    UPDATE `ocorrencia`
    SET
        `rating` = (SELECT AVG(r.rating) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = NEW.ocorrencia_id),
        `rating_count` = (SELECT COUNT(*) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = NEW.ocorrencia_id)
    WHERE `cod` = NEW.ocorrencia_id;
END$$

-- Gatilho para atualizar a média de rating após ATUALIZAR uma avaliação
CREATE TRIGGER `trg_after_rating_update`
AFTER UPDATE ON `ocorrencia_rating`
FOR EACH ROW
BEGIN
    UPDATE `ocorrencia`
    SET
        `rating` = (SELECT AVG(r.rating) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = NEW.ocorrencia_id),
        `rating_count` = (SELECT COUNT(*) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = NEW.ocorrencia_id)
    WHERE `cod` = NEW.ocorrencia_id;
END$$

-- Gatilho para atualizar a média de rating após DELETAR uma avaliação
CREATE TRIGGER `trg_after_rating_delete`
AFTER DELETE ON `ocorrencia_rating`
FOR EACH ROW
BEGIN
    UPDATE `ocorrencia`
    SET
        `rating` = COALESCE((SELECT AVG(r.rating) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = OLD.ocorrencia_id), 0),
        `rating_count` = (SELECT COUNT(*) FROM `ocorrencia_rating` r WHERE r.ocorrencia_id = OLD.ocorrencia_id)
    WHERE `cod` = OLD.ocorrencia_id;
END$$

DELIMITER ;


-- =================================================================
-- DADOS INICIAIS E ATUALIZAÇÕES
-- =================================================================

-- Inserir perfis de usuário padrão
INSERT INTO `perfil` (`cod`, `perfil`) VALUES (1, 'Administrador'), (2, 'Usuario')
ON DUPLICATE KEY UPDATE perfil=VALUES(perfil);

-- Inserir configurações padrão do sistema
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
('site_name', 'SmartSecurity', 'Nome do site'),
('site_description', 'Sistema de monitoramento de segurança pública', 'Descrição do site'),
('max_upload_size_bytes', '5242880', 'Tamanho máximo de upload em bytes (5MB)'),
('allowed_image_types', 'jpg,jpeg,png,gif', 'Tipos de imagem permitidos'),
('occurrences_per_page', '10', 'Número de ocorrências por página'),
('enable_email_notifications', '1', 'Habilitar notificações por email (1=sim, 0=não)'),
('enable_public_statistics', '1', 'Habilitar estatísticas públicas (1=sim, 0=não)')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value), description=VALUES(description);

-- Inserir usuário Super Admin para desenvolvedores
-- ATENÇÃO: Substitua a senha por um hash seguro gerado pela sua aplicação.
-- O hash abaixo é apenas um placeholder e NÃO é seguro.
INSERT INTO `usuario` (`nome`, `sobrenome`, `email`, `senha`, `cpf_hash`, `perfil_cod`, `dt_nascimento`, `sexo`)
SELECT 'Admin', 'Dev', 'developer@smartsecurity.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', SHA2('00000000000000', 256), 1, '1990-01-01', 'O'
WHERE NOT EXISTS (SELECT 1 FROM `usuario` WHERE `email` = 'developer@smartsecurity.com');


-- [ATENÇÃO] Atualização de senhas antigas (APENAS PARA DESENVOLVIMENTO)
-- Este comando atualiza todas as senhas antigas (MD5, 32 caracteres) para 'password'.
-- NÃO FAÇA ISSO EM PRODUÇÃO com uma senha fixa.
UPDATE `usuario`
SET `senha` = '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e' -- hash para 'password'
WHERE LENGTH(`senha`) = 32 AND `senha` NOT LIKE '$2y$%';


-- Fim do script de migração