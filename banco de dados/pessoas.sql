-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/04/2026 às 01:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `imc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `idpessoa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `idade` int(11) NOT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoas`
--

INSERT INTO `pessoas` (`idpessoa`, `nome`, `sobrenome`, `idade`, `peso`, `altura`) VALUES
(8, 'Carlos', 'Silva', 25, 80, 1.75),
(9, 'Ana', 'Souza', 22, 60, 1.65),
(10, 'Marcos', 'Oliveira', 30, 90, 1.80),
(11, 'Juliana', 'Pereira', 28, 58, 1.62),
(12, 'Fernanda', 'Costa', 35, 70, 1.68),
(13, 'Lucas', 'Rodrigues', 19, 65, 1.72),
(14, 'Bruno', 'Almeida', 40, 85, 1.78),
(15, 'Camila', 'Nunes', 27, 55, 1.60),
(16, 'Rafael', 'Gomes', 31, 88, 1.82),
(17, 'Patricia', 'Martins', 29, 62, 1.66),
(18, 'Diego', 'Barbosa', 24, 77, 1.74),
(19, 'Larissa', 'Fernandes', 21, 59, 1.63),
(20, 'André', 'Rocha', 33, 92, 1.85),
(21, 'Beatriz', 'Carvalho', 26, 57, 1.61),
(22, 'Gustavo', 'Araujo', 38, 95, 1.88),
(23, 'Renata', 'Ribeiro', 34, 68, 1.67),
(24, 'Eduardo', 'Teixeira', 45, 100, 1.90),
(25, 'Vanessa', 'Correia', 23, 61, 1.64),
(26, 'Felipe', 'Moura', 36, 89, 1.79),
(27, 'Aline', 'Batista', 28, 56, 1.59);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`idpessoa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `idpessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
