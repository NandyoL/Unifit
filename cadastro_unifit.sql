-- Cria o banco de dados se ainda não existir
CREATE DATABASE IF NOT EXISTS unifit;
USE unifit;

-- Remove a tabela 'usuarios' se ela já existir
DROP TABLE IF EXISTS usuarios;

-- Cria a tabela 'usuarios'
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(45) NOT NULL,
    nomeMaterno VARCHAR(45) NOT NULL,
    cpf VARCHAR(45) NOT NULL,
    email VARCHAR(100) NOT NULL,
    dataNasc DATE,
    telefone VARCHAR(20),
    celular VARCHAR(20),
    cep VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    login VARCHAR(50),
    senha VARCHAR(255)
);

INSERT INTO usuarios (nome, nomeMaterno, cpf, email, dataNasc, telefone, celular, cep, bairro, cidade, login, senha)
VALUES ('João Silva', 'Maria Silva', '12345678901', 'joao@example.com', '1990-05-15', '1122334455', '11987654321', '12345678', 'Centro', 'São Paulo', 'joao23', 'hashi123');

select * from usuarios;