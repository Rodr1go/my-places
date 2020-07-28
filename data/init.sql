CREATE DATABASE my_places;

use my_places;

CREATE TABLE locais (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	nome VARCHAR(100) NOT NULL,
	cep VARCHAR(8) NOT NULL,
	logradouro VARCHAR(150) NOT NULL,
	complemento VARCHAR(100),
	numero VARCHAR(6),
    bairro VARCHAR(100),
    uf VARCHAR(2),
    cidade VARCHAR(100),
	data TIMESTAMP
);