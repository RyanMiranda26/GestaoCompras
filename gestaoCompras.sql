-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Jul-2026 às 09:15
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestaoCompras`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `nif` int(9) NOT NULL,
  `pass` text NOT NULL,
  `tipo` enum('admin','geral') NOT NULL DEFAULT 'geral'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`id`, `nome`, `nif`, `pass`, `tipo`) VALUES
(1, 'Administrador', 111111111, 'admin123', 'admin'),
(2, 'Utilizador Geral', 222222222, 'geral123', 'geral');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigo`
--

CREATE TABLE `artigo` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `quantidadeMinima` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `artigo`
--

INSERT INTO `artigo` (`id`, `nome`, `quantidade`, `quantidadeMinima`) VALUES
(1, 'Arroz', 2, 3),
(2, 'Massa', 4, 2),
(3, 'Leite', 1, 4),
(4, 'Detergente da Loiça', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidoExtra`
--

CREATE TABLE `pedidoExtra` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `idUtilizador` int(11) NOT NULL,
  `estado` enum('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
  `dataPedido` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `artigo`
--
ALTER TABLE `artigo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedidoExtra`
--
ALTER TABLE `pedidoExtra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtilizador` (`idUtilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `artigo`
--
ALTER TABLE `artigo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidoExtra`
--
ALTER TABLE `pedidoExtra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pedidoExtra`
--
ALTER TABLE `pedidoExtra`
  ADD CONSTRAINT `pedidoExtra_ibfk_1` FOREIGN KEY (`idUtilizador`) REFERENCES `utilizador` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
