-- Migração para modernizar o banco de dados SmartSecurity
-- Versão: 001
-- Data: 2025-01-07

-- Usar o banco de dados
USE smartsecurity;

-- Criação mínima das tabelas para permitir as alterações subsequentes

CREATE DATABASE IF NOT EXISTS smartsecurity;
USE smartsecurity;

CREATE TABLE perfil (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    perfil VARCHAR(100) NOT NULL
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    sobrenome VARCHAR(100),
    email VARCHAR(100),
    senha VARCHAR(255),
    perfil_cod INT,
    FOREIGN KEY (perfil_cod) REFERENCES perfil(cod)
);

CREATE TABLE ocorrencia (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    tipo VARCHAR(100),
    titulo_registro VARCHAR(255),
    descricao TEXT,
    dt_registro DATETIME,
    localizacao VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE celular (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    modelo VARCHAR(100),
    imei VARCHAR(20),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE comentario (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    texto TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Atualizar tabela ocorrencia
ALTER TABLE ocorrencia 
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
ADD COLUMN latitude DECIMAL(10, 8) NULL,
ADD COLUMN longitude DECIMAL(11, 8) NULL,
ADD COLUMN images TEXT NULL COMMENT 'JSON array of image paths',
ADD COLUMN views_count INT DEFAULT 0,
ADD COLUMN rating DECIMAL(3,2) DEFAULT 0.00,
ADD COLUMN rating_count INT DEFAULT 0,
ADD INDEX idx_tipo (tipo),
ADD INDEX idx_localizacao (localizacao),
ADD INDEX idx_dt_registro (dt_registro),
ADD INDEX idx_status (status),
ADD INDEX idx_usuario_id (usuario_id),
ADD INDEX idx_coordinates (latitude, longitude);

-- Atualizar tabela celular
ALTER TABLE celular 
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN status ENUM('active', 'lost', 'found', 'stolen') DEFAULT 'active',
ADD COLUMN image VARCHAR(255) NULL,
ADD INDEX idx_usuario_id (usuario_id),
ADD INDEX idx_status (status);

-- Atualizar tabela comentario
ALTER TABLE comentario 
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN ocorrencia_id INT NULL,
ADD COLUMN parent_id INT NULL COMMENT 'Para respostas a comentários',
ADD COLUMN status ENUM('active', 'hidden', 'deleted') DEFAULT 'active',
ADD INDEX idx_usuario_id (usuario_id),
ADD INDEX idx_ocorrencia_id (ocorrencia_id),
ADD INDEX idx_parent_id (parent_id),
ADD INDEX idx_status (status),
ADD FOREIGN KEY (ocorrencia_id) REFERENCES ocorrencia(cod) ON DELETE CASCADE,
ADD FOREIGN KEY (parent_id) REFERENCES comentario(cod) ON DELETE CASCADE;

-- Criar tabela de ratings para ocorrências
CREATE TABLE IF NOT EXISTS ocorrencia_rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ocorrencia_id INT NOT NULL,
    usuario_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_occurrence (ocorrencia_id, usuario_id),
    FOREIGN KEY (ocorrencia_id) REFERENCES ocorrencia(cod) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
    INDEX idx_ocorrencia_id (ocorrencia_id),
    INDEX idx_usuario_id (usuario_id)
);

-- Criar tabela de notificações
CREATE TABLE IF NOT EXISTS notificacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    tipo ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
    lida BOOLEAN DEFAULT FALSE,
    url VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_lida (lida),
    INDEX idx_created_at (created_at)
);

-- Criar tabela de logs de atividade
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE SET NULL,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
);

-- Criar tabela de configurações do sistema
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
);

-- Inserir configurações padrão
INSERT INTO system_settings (setting_key, setting_value, description) VALUES
('site_name', 'SmartSecurity', 'Nome do site'),
('site_description', 'Sistema de monitoramento de segurança pública', 'Descrição do site'),
('max_upload_size', '5242880', 'Tamanho máximo de upload em bytes (5MB)'),
('allowed_image_types', 'jpg,jpeg,png,gif', 'Tipos de imagem permitidos'),
('occurrences_per_page', '20', 'Número de ocorrências por página'),
('enable_email_notifications', '1', 'Habilitar notificações por email'),
('enable_public_statistics', '1', 'Habilitar estatísticas públicas')
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;

-- Atualizar dados existentes
-- Converter senhas MD5 existentes (ATENÇÃO: Isso é apenas para desenvolvimento)
-- Em produção, os usuários deveriam redefinir suas senhas
UPDATE usuario SET senha = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE LENGTH(senha) = 32;

-- Adicionar índices para melhor performance
ALTER TABLE ocorrencia ADD FULLTEXT(titulo_registro, descricao);
ALTER TABLE usuario ADD FULLTEXT(nome, sobrenome);

-- Criar view para estatísticas rápidas
CREATE OR REPLACE VIEW v_dashboard_stats AS
SELECT 
    (SELECT COUNT(*) FROM ocorrencia) as total_occurrences,
    (SELECT COUNT(*) FROM ocorrencia WHERE tipo = 'Assalto') as total_assaults,
    (SELECT COUNT(*) FROM ocorrencia WHERE tipo = 'Perda') as total_losses,
    (SELECT COUNT(*) FROM ocorrencia WHERE DATE(dt_registro) = CURDATE()) as today_occurrences,
    (SELECT COUNT(*) FROM ocorrencia WHERE DATE(dt_registro) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as week_occurrences,
    (SELECT COUNT(*) FROM ocorrencia WHERE DATE(dt_registro) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as month_occurrences,
    (SELECT COUNT(*) FROM usuario) as total_users,
    (SELECT COUNT(*) FROM usuario WHERE perfil_cod = 1) as admin_users,
    (SELECT COUNT(*) FROM usuario WHERE perfil_cod = 2) as regular_users;

-- Criar view para ocorrências com dados do usuário
CREATE OR REPLACE VIEW v_occurrences_with_user AS
SELECT 
    o.*,
    u.nome,
    u.sobrenome,
    u.email,
    p.perfil,
    CONCAT(u.nome, ' ', u.sobrenome) as user_full_name
FROM ocorrencia o
LEFT JOIN usuario u ON o.usuario_id = u.id
LEFT JOIN perfil p ON u.perfil_cod = p.cod;

-- Criar triggers para atualizar ratings automaticamente
DELIMITER //

CREATE TRIGGER update_occurrence_rating_after_insert
AFTER INSERT ON ocorrencia_rating
FOR EACH ROW
BEGIN
    UPDATE ocorrencia 
    SET 
        rating = (SELECT AVG(rating) FROM ocorrencia_rating WHERE ocorrencia_id = NEW.ocorrencia_id),
        rating_count = (SELECT COUNT(*) FROM ocorrencia_rating WHERE ocorrencia_id = NEW.ocorrencia_id)
    WHERE cod = NEW.ocorrencia_id;
END//

CREATE TRIGGER update_occurrence_rating_after_update
AFTER UPDATE ON ocorrencia_rating
FOR EACH ROW
BEGIN
    UPDATE ocorrencia 
    SET 
        rating = (SELECT AVG(rating) FROM ocorrencia_rating WHERE ocorrencia_id = NEW.ocorrencia_id),
        rating_count = (SELECT COUNT(*) FROM ocorrencia_rating WHERE ocorrencia_id = NEW.ocorrencia_id)
    WHERE cod = NEW.ocorrencia_id;
END//

CREATE TRIGGER update_occurrence_rating_after_delete
AFTER DELETE ON ocorrencia_rating
FOR EACH ROW
BEGIN
    UPDATE ocorrencia 
    SET 
        rating = COALESCE((SELECT AVG(rating) FROM ocorrencia_rating WHERE ocorrencia_id = OLD.ocorrencia_id), 0),
        rating_count = (SELECT COUNT(*) FROM ocorrencia_rating WHERE ocorrencia_id = OLD.ocorrencia_id)
    WHERE cod = OLD.ocorrencia_id;
END//

DELIMITER ;

-- Inserir dados de exemplo para testes (opcional)
INSERT INTO notificacoes (usuario_id, titulo, mensagem, tipo) 
SELECT id, 'Bem-vindo ao SmartSecurity!', 'Sua conta foi criada com sucesso. Explore as funcionalidades do sistema.', 'success'
FROM usuario 
WHERE id NOT IN (SELECT DISTINCT usuario_id FROM notificacoes WHERE titulo = 'Bem-vindo ao SmartSecurity!');

COMMIT;

