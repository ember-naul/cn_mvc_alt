DROP DATABASE if exists dbcasanegocios;
CREATE DATABASE dbcasanegocios;
USE dbcasanegocios;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_servico` 			int NOT NULL,
  `nota` 				tinyint NOT NULL,
  `comentário` 			text COLLATE utf8mb4_unicode_ci,
  KEY `id_servico` (`id_servico`)
) ;

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` 				varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descrição` 			text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` 			int NOT NULL,
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_cliente` 			int NOT NULL,
  `id_profissional` 	int NOT NULL,
  `data_inicio` 		datetime NOT NULL,
  `data_fim` 			datetime DEFAULT NULL,
  `valor` 				decimal(10,2) DEFAULT NULL,
  `status_servico` 		enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_cliente` (`id_cliente`),
  KEY `id_profissional` (`id_profissional`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` 				int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_cliente` 		int,
  `id_profissional` int,
  `cep` 			char(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` 		varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` 			varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` 			varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` 			varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `id_cliente` (`id_cliente`),
  KEY `id_profissional` (`id_profissional`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `habilidades` (
  `id` 				int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` 			varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` 		text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_contrato` 		int NOT NULL,
  `data_pagamento` 		date NOT NULL,
  `valor` 				decimal(10,2) NOT NULL,
  `status_pagamento` 	varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_contrato` (`id_contrato`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `profissionais` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` 			int NOT NULL,
  `cnpj`				char(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `profissionais_categorias` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_profissional` 	int NOT NULL,
  `id_categoria` 		int NOT NULL,
  KEY `id_profissional` (`id_profissional`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `profissionais_habilidades` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_profissional` 	int NOT NULL,
  `id_habilidade` 		int NOT NULL,
  KEY `id_profissional` (`id_profissional`),
  KEY `id_habilidade` (`id_habilidade`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `servicos` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_contrato` 		int NOT NULL,
  `data_hora`			datetime NOT NULL,
  `status_servico` 		varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id_contrato` (`id_contrato`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` 					int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` 				varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` 				varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` 			char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` 				char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg` 					char(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` 				varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_verificacao` 	varchar(255) COLLATE utf8mb4_unicode_ci,
  `codigo_expiracao` 	datetime COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `avaliacoes` (`id`, `id_servico`, `nota`, `comentário`) VALUES
(1, 1, 5, 'Excelente serviço, muito satisfeito!'),
(2, 2, 4, 'Bom serviço, mas poderia melhorar a pontualidade.');

INSERT INTO `categorias` (`id`, `nome`, `descrição`) VALUES
(1, 'Jardinagem', 'Serviços relacionados ao cuidado e manutenção de jardins'),
(2, 'Limpeza', 'Serviços de limpeza residencial e comercial');

INSERT INTO `clientes` (`id`, `id_usuario`) VALUES
(1, 1),
(2, 2);

INSERT INTO `contratos` (`id`, `id_cliente`, `id_profissional`, `data_inicio`, `data_fim`, `valor`, `status_servico`) VALUES
(1, 1, 1, '2024-07-01 00:00:00', '2024-12-31 00:00:00', '1200.00', 'ativo');

INSERT INTO `habilidades` (`id`, `nome`, `descricao`) VALUES
(1, 'Jardinagem', 'Cuidados e manutenção de jardins'),
(2, 'Limpeza', 'Serviços de limpeza residencial e comercial');

INSERT INTO `pagamentos` (`id`, `id_contrato`, `data_pagamento`, `valor`, `status_pagamento`) VALUES
(1, 1, '2024-07-01', '1200.00', 'pago');

INSERT INTO `profissionais` (`id`, `id_usuario`, `cnpj`) VALUES
(1, 3, '78823734523255');

INSERT INTO `profissionais_categorias` (`id`, `id_profissional`, `id_categoria`) VALUES
(1, 1, 1),
(2, 1, 2);

INSERT INTO `profissionais_habilidades` (`id`, `id_profissional`, `id_habilidade`) VALUES
(1, 1, 1),
(2, 1, 2);

INSERT INTO `servicos` (`id`, `id_contrato`, `data_hora`, `status_servico`) VALUES
(1, 1, '2024-07-05 09:00:00', 'solicitado'),
(2, 1, '2024-07-10 09:00:00', 'em_andamento');

INSERT INTO `usuarios` (`id`, `nome`, `email`, `celular`, `cpf`, `rg`, `senha`) VALUES
(1, 'Luan', 'luan@gmail.com', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;