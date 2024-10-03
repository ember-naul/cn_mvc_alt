-- Active: 1725406851568@@127.0.0.1@3306@dbcasanegocios
DROP DATABASE if exists dbcasanegocios;
CREATE DATABASE dbcasanegocios;
USE dbcasanegocios;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = '-03:00';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` 						int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_cliente` 				int NOT NULL,
  `id_profissional`			int NOT NULL,
  `id_servico` 				int NOT NULL,
  `nota` 					tinyint NOT NULL,
  `comentario` 				text COLLATE utf8mb4_unicode_ci,
  `tipo_avaliacao` 			enum('cliente', 'profissional') COLLATE utf8mb4_unicode_ci NOT NULL,
   KEY `id_servico` 		(`id_servico`),
   KEY `id_cliente` 		(`id_cliente`),
   KEY `id_profissional` 	(`id_profissional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `clientes` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` 				int NOT NULL,
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_cliente` 				int NOT NULL,
  `id_profissional` 		int NOT NULL,
  `data_inicio` 			datetime NOT NULL,
  `data_fim` 			  	datetime DEFAULT NULL,
  `valor` 				  	decimal(10,2) DEFAULT NULL,
  `status_servico` 	        enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_cliente` (`id_cliente`),
  KEY `id_profissional` (`id_profissional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` 				    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_cliente` 		  	int,
  `id_profissional` 	int,
  `cep` 			    char(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` 		    varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` 			    varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` 			    varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` 			    varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` 			decimal(10,8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` 			decimal(11,8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `id_cliente` (`id_cliente`),
  KEY `id_profissional` (`id_profissional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `habilidades` (
  `id` 				        int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` 			        varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` 		        text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` 				    	int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_chat` 			    varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` 				text COLLATE utf8mb4_unicode_ci,
  KEY `id_chat` (`id_chat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_contrato` 		  	int NOT NULL,
  `data_pagamento` 			date NOT NULL,
  `valor` 				    decimal(10,2) NOT NULL,
  `status_pagamento` 		varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_contrato` (`id_contrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `profissionais` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` 				int NOT NULL,
  `cnpj`				    	char(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude`				DECIMAL(10, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` 				DECIMAL(11, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo` 					DECIMAL(10,2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `profissionais_habilidades` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_profissional` 	    int NOT NULL,
  `id_habilidade` 		    int NOT NULL,
  `data_cadastro` 		    date NOT NULL,
  KEY `id_profissional` (`id_profissional`),
  KEY `id_habilidade` (`id_habilidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `servicos` (
  `id` 					    int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_contrato` 		int NOT NULL,
  `data_hora`			  datetime NOT NULL,
  `status_servico` 	varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_contrato` (`id_contrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`              int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome`            varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email`           varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular`         char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf`             char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg`                      char(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha`                       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_verificacao`          varchar(255) COLLATE utf8mb4_unicode_ci,
  `codigo_expiracao`            datetime COLLATE utf8mb4_unicode_ci,
  `tipo` ENUM('usuario', 'admin') COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `avaliacoes` (`id`, `id_cliente`, `id_profissional` ,`id_servico`, `nota`, `comentario`, `tipo_avaliacao`) VALUES
(1, 1, 1, 1, 5, 'Excelente serviço, muito satisfeito!', 1),
(2, 1, 1, 1, 5, 'Bom serviço, mas poderia melhorar a pontualidade.', 2);

INSERT INTO `contratos` (`id`, `id_cliente`, `id_profissional`, `data_inicio`, `data_fim`, `valor`, `status_servico`) VALUES
(1, 1, 1, '2024-07-01 00:00:00', '2024-12-31 00:00:00', '1200.00', 'ativo');

INSERT INTO `habilidades` (`id`, `nome`, `descricao`) VALUES
(1, 'Jardinagem', 'Cuidados e manutenção de jardins'),
(2, 'Limpeza', 'Serviços de limpeza residencial e comercial'),
(3, 'Cozinheira(o)', 'Serviços de cozinha residencial e comercial');

INSERT INTO `pagamentos` (`id`, `id_contrato`, `data_pagamento`, `valor`, `status_pagamento`) VALUES
(1, 1, '2024-07-01', '1200.00', 'pago');

INSERT INTO `profissionais_habilidades` (`id`, `id_profissional`, `id_habilidade`) VALUES
(1, 1, 1);

INSERT INTO `servicos` (`id`, `id_contrato`, `data_hora`, `status_servico`) VALUES
(1, 1, '2024-07-05 09:00:00', 'solicitado');

INSERT INTO `usuarios` (`id`, `nome`, `email`, `celular`, `cpf`, `rg`, `senha`, `tipo`) VALUES
(1, 'Luan', 'lluann930@gmail.com', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;