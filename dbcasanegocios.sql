-- Active: 1725406851568@@127.0.0.1@3306@dbcasanegocios

DROP DATABASE if exists dbcasanegocios;
CREATE DATABASE dbcasanegocios;
USE dbcasanegocios;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = '-03:00';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `avaliacoes`
(
    `id`              int PRIMARY KEY                                             NOT NULL AUTO_INCREMENT,
    `id_cliente`      int                                                         NOT NULL,
    `id_profissional` int                                                         NOT NULL,
    `id_servico`      int                                                         NOT NULL,
    `nota`            tinyint                                                     NOT NULL,
    `comentario`      text COLLATE utf8mb4_unicode_ci,
    `tipo_avaliacao`  enum ('cliente', 'profissional') COLLATE utf8mb4_unicode_ci NOT NULL,
    KEY `id_servico` (`id_servico`),
    KEY `id_cliente` (`id_cliente`),
    KEY `id_profissional` (`id_profissional`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `clientes`
(
    `id`         int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_usuario` int             NOT NULL,
    `latitude`   DECIMAL(10, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `longitude`  DECIMAL(11, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    KEY `id_usuario` (`id_usuario`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `chat`
(
    `id`            int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_contrato`   int             NOT NULL,
    KEY `id_contrato` (`id_contrato`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contratos`
(
    `id`              int PRIMARY KEY                                                  NOT NULL AUTO_INCREMENT,
    `id_cliente`      int                                                              NOT NULL,
    `id_profissional` int                                                              NOT NULL,
    `data_inicio`     datetime                                                         NOT NULL,
    `data_fim`        datetime       DEFAULT NULL,
    `valor`           decimal(10, 2) DEFAULT NULL,
    `status_contrato` enum ('pendente', 'inativo', 'ativo', 'concluido', 'cancelado') COLLATE utf8mb4_unicode_ci NOT NULL,
    KEY `id_cliente` (`id_cliente`),
    KEY `id_profissional` (`id_profissional`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enderecos`
(
    `id`              int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_cliente`      int,
    `id_profissional` int,
    `cep`             char(9) COLLATE utf8mb4_unicode_ci        DEFAULT NULL,
    `numero`          varchar(6) COLLATE utf8mb4_unicode_ci     DEFAULT NULL,
    `latitude`        decimal(10, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `longitude`       decimal(11, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    KEY `id_cliente` (`id_cliente`),
    KEY `id_profissional` (`id_profissional`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `habilidades`
(
    `id`        int PRIMARY KEY                         NOT NULL AUTO_INCREMENT,
    `nome`      varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `descricao` text COLLATE utf8mb4_unicode_ci
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `mensagens`
(
    `id`       int PRIMARY KEY                         NOT NULL AUTO_INCREMENT,
    `id_chat`  varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `mensagem` text COLLATE utf8mb4_unicode_ci,
    `timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP COLLATE utf8mb4_unicode_ci NOT NULL,
    `tipo_usuario` ENUM('cliente', 'profissional') COLLATE utf8mb4_unicode_ci NOT NULL,
    KEY `id_chat` (`id_chat`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pagamentos`
(
    `id`               int PRIMARY KEY                                                        NOT NULL AUTO_INCREMENT,
    `id_contrato`      int                                                                    NOT NULL,
    `data_pagamento`   date                                                                   NOT NULL,
    `valor`            decimal(10, 2)                                                         NOT NULL,
    `status_pagamento` enum ('pendente', 'realizado', 'cancelado') COLLATE utf8mb4_unicode_ci NOT NULL,
    KEY `id_contrato` (`id_contrato`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `tipos_pagamentos`
(
    `id`             int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `tipo_pagamento` enum ('PIX', 'Credito') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `profissionais`
(
    `id`         int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_usuario` int             NOT NULL,
    `cnpj`       char(14) COLLATE utf8mb4_unicode_ci       DEFAULT NULL,
    `latitude`   DECIMAL(10, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `longitude`  DECIMAL(11, 8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `saldo`      DECIMAL(10, 2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `status`	   ENUM('nao-pareando', 'pareando') COLLATE utf8mb4_unicode_ci NOT NULL,   
KEY `id_usuario` (`id_usuario`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `profissionais_habilidades`
(
    `id`              int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_profissional` int             NOT NULL,
    `id_habilidade`   int             NOT NULL,
    `data_cadastro`   date            NOT NULL,
    KEY `id_profissional` (`id_profissional`),
    KEY `id_habilidade` (`id_habilidade`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `servicos`
(
    `id`             int PRIMARY KEY                        NOT NULL AUTO_INCREMENT,
    `id_contrato`    int                                    NOT NULL,
    `data_hora`      datetime                               NOT NULL,
    `status_servico` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
    KEY `id_contrato` (`id_contrato`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `usuarios`
(
    `id`                 int PRIMARY KEY                         NOT NULL AUTO_INCREMENT,
    `nome`               varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email`              varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `celular`            char(11) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `cpf`                char(11) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `rg`                 char(9) COLLATE utf8mb4_unicode_ci      NOT NULL,
    `imagem`             varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `senha`              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `codigo_verificacao` varchar(255) COLLATE utf8mb4_unicode_ci,
    `codigo_expiracao`   datetime COLLATE utf8mb4_unicode_ci,
    `tipo`               ENUM ('usuario', 'admin') COLLATE utf8mb4_unicode_ci
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;


INSERT INTO `avaliacoes` (`id_cliente`, `id_profissional`, `id_servico`, `nota`, `comentario`, `tipo_avaliacao`)
VALUES (1, 1, 1, 5, 'Excelente serviço, muito satisfeito!', 'cliente'),
       (1, 1, 1, 5, 'Bom serviço, mas poderia melhorar a pontualidade.', 'profissional');

INSERT INTO `contratos` (`id`, `id_cliente`, `id_profissional`, `data_inicio`, `data_fim`, `valor`, `status_contrato`)
VALUES (1, 1, 1, '2024-07-01 00:00:00', '2024-12-31 00:00:00', '1200.00', 'ativo');

INSERT INTO `habilidades` (`id`, `nome`, `descricao`)
VALUES (1, 'Jardinagem', 'Cuidados e manutenção de jardins'),
       (2, 'Limpeza', 'Serviços de limpeza residencial e comercial'),
       (3, 'Cozinheira(o)', 'Serviços de cozinha residencial e comercial'),
       (4, 'Faxineiro(a)', 'Responsável por limpar e organizar ambientes.'),
       (5, 'Babysitter (Babá)', 'Cuida de crianças/bebês na ausência de responsáveis.'),
       (6, 'Organizador(a)', 'Profissional que organiza ambientes residenciais e comerciais, otimizando espaços.'),
       (7, 'Jardineiro(a) de Emergência', 'Serviços rápidos de jardinagem, como poda e limpeza de áreas externas.'),
       (8, 'Cuidador(a) de Animais', 'Profissional que cuida de pets, oferecendo alimentação e passeios.'),
       (9, 'Lavadeira', 'Serviço de lavanderia, incluindo lavagem, secagem e passagem de roupas.'),
       (10, 'Reparador(a) Doméstico',
        'Realiza pequenos reparos e manutenções em casa, como troca de lâmpadas e consertos simples.'),
       (11, 'Assistente Pessoal', 'Ajuda com tarefas do dia a dia, como compras e agendamentos.'),
       (12, 'Serviço de Entrega de Compras',
        'Profissional que realiza compras e entrega diretamente na residência do cliente.'),
       (13, 'Serviço de Desentupimento', 'Profissional que realiza desentupimentos rápidos em encanamentos e ralos.'),
       (14, 'Cozinheiro(a) de Refeições Rápidas', 'Prepara refeições simples e rápidas, como lanches e pratos do dia.'),
       (15, 'Montador(a) de Móveis', 'Realiza a montagem de móveis e objetos de decoração.'),
       (16, 'Babá Noturna', 'Cuida de crianças durante a noite, proporcionando conforto e segurança.'),
       (17, 'Técnico em Eletrodomésticos',
        'Faz reparos e manutenções em eletrodomésticos, como geladeiras e máquinas de lavar.'),
       (18, 'Esteticista Domiciliar', 'Oferece serviços de estética, como manicure e pedicure, no conforto do lar.'),
       (19, 'Cuidador(a) de Idosos', 'Apoia idosos com cuidados diários, garantindo bem-estar e segurança.'),
       (20, 'Serviço de Passadoria', 'Profissional que passa roupas de maneira rápida e eficiente.'),
       (21, 'Limpeza Pós-Obra', 'Realiza limpeza profunda após reformas e construções.'),
       (22, 'Apoio a Eventos', 'Auxilia na organização e execução de pequenos eventos em casa.'),
       (23, 'Cuidador(a) de Plantas', 'Responsável pelo cuidado e manutenção de plantas internas e externas.'),
       (24, 'Serviço de Compras', 'Realiza compras de supermercado e outras necessidades do lar.'),
       (25, 'Assistente de Estudo', 'Ajuda crianças e adolescentes com lições de casa e estudos.'),
       (26, 'Reorganizador(a) de Armários', 'Ajuda a reorganizar e otimizar o espaço em armários e closets.');

INSERT INTO `pagamentos` (`id`, `id_contrato`, `data_pagamento`, `valor`, `status_pagamento`)
VALUES (1, 1, '2024-07-01', '1200.00', 'pago');

INSERT INTO `profissionais`(`id_usuario`, `cnpj`, `latitude`, `longitude`, `saldo`)
VALUES ('2', '1', null, null, null),
       ('3', '1', null, null, null),
       ('4', '1', null, null, null),
       ('5', '1', null, null, null);

INSERT INTO `profissionais_habilidades` (`id`, `id_profissional`, `id_habilidade`)
VALUES (1, 1, 1);

INSERT INTO `servicos` (`id`, `id_contrato`, `data_hora`, `status_servico`)
VALUES (1, 1, '2024-07-05 09:00:00', 'solicitado');

INSERT INTO `usuarios` (`nome`, `email`, `celular`, `cpf`, `rg`, `senha`, `tipo`)
VALUES ('Luan', 'lluann930@gmail.com', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 2),
       ('brayan araujo', 'brayan.aramar@gmail.com', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 2),
       ('teste1', 'a@1', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste2', 'a@2', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste3', 'a@3', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste4', 'a@4', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste5', 'a@5', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste6', 'a@6', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1),
       ('teste7', 'a@7', '1', '1', '1', 'adcd7048512e64b48da55b027577886ee5a36350', 1);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;