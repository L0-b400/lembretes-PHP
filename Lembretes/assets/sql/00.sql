CREATE DATABASE euro_consultoria;

USE euro_consultoria;

-- Tabela para armazenar lembretes
CREATE TABLE lembretes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familia VARCHAR(255) NOT NULL,
    requerente VARCHAR(255) NOT NULL,
    data_lembrete DATE NOT NULL,
    data_pagamento DATE
);

-- Tabela para armazenar apresentações
CREATE TABLE apresentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familia VARCHAR(255) NOT NULL,
    data_apresentacao DATE NOT NULL
);

-- Tabela para armazenar negociações
CREATE TABLE negociacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familia VARCHAR(255) NOT NULL,
    valor_acordado DECIMAL(10, 2) NOT NULL,
    data_negociacao DATE NOT NULL,
    tipo_negociacao VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL
);

-- Tabela para armazenar aditivos
CREATE TABLE aditivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familia VARCHAR(255) NOT NULL,
    data_negociacao DATE NOT NULL,
    descricao TEXT NOT NULL,
    valor_acordado DECIMAL(10, 2) NOT NULL
);
