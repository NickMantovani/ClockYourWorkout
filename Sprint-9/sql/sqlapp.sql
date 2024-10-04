-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS acad_agenda;
USE acad_agenda;

-- Criação da tabela 'cadastro'
CREATE TABLE IF NOT EXISTS cadastro (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome CHAR(69) NOT NULL,
    email VARCHAR(69) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT NULL
);

-- Criação da tabela 'horarios_disponiveis'
CREATE TABLE IF NOT EXISTS horarios_disponiveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dia DATE NOT NULL,
    hora TIME NOT NULL,
    disponivel BOOLEAN DEFAULT 1
);

-- Criação da tabela 'musculos'
CREATE TABLE IF NOT EXISTS musculos (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    musculo CHAR(20),
    nome CHAR(69)
);

-- Criação da tabela 'agendamentos'
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id) ON DELETE CASCADE
);

-- Criação da tabela 'suporte'
CREATE TABLE IF NOT EXISTS suporte (
    id INT AUTO_INCREMENT PRIMARY KEY,               
    id_usuario INT NOT NULL,                        
    assunto VARCHAR(255) NOT NULL,                 
    mensagem TEXT NOT NULL,                         
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (id_usuario) REFERENCES cadastro(id) 
);


CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agendamento_id INT NOT NULL,
    usuario_id INT NOT NULL,
    feedback TEXT NOT NULL,
    FOREIGN KEY (agendamento_id) REFERENCES agendamentos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id) ON DELETE CASCADE
);

CREATE TABLE metas_treino (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    meta_tipo VARCHAR(50) NOT NULL,
    valor_meta INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id)
);

CREATE TABLE atividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    atividade VARCHAR(255) NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id)
);

CREATE TABLE IF NOT EXISTS desafios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES cadastro(id) ON DELETE CASCADE
);




-- Comandos de consulta (apenas para verificar as tabelas)
SELECT * FROM cadastro;
SELECT * FROM horarios_disponiveis;
SELECT * FROM musculos;
SELECT * FROM agendamentos;
SELECT * FROM suporte;
SELECT * FROM feedback;
SELECT * FROM metas_treinos;
SELECT * FROM atividades;

-- Comandos para excluir as tabelas (utilizar com cautela)
DROP TABLE IF EXISTS horarios_disponiveis;
DROP TABLE IF EXISTS cadastro;
DROP TABLE IF EXISTS musculos;
DROP TABLE IF EXISTS agendamentos;
DROP TABLE IF EXISTS suporte;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS metas_treinos;
DROP TABLE IF EXISTS atividades;
