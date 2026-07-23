-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21/06/2024 às 23:30
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
-- Banco de dados: `VoltaAoMundo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `mensagem` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `aprovado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `nome`, `mensagem`, `email`, `data_criacao`, `aprovado`) VALUES
(1, 'joao', 'muito bom ', 'jao@gmail.com', '2024-06-02 00:00:00', 1),
(2, 'joao', 'muito bom ', 'jao@gmail.com', '2024-06-02 00:00:00', 1),
(3, 'Ronaldo', 'A cara, esse design ta muito padrão né, todo site tem uma design igual, voce não é nada original', 'brilhamuitonocurintia@gmail.com', '2024-06-02 00:00:00', 1),
(4, 'joao paulo', 'vai dar 18 horas doido', 'briante@gmail.com', '2024-06-02 00:00:00', 1),
(5, 'joao paulo', 'vai dar 18 horas doido', 'briante@gmail.com', '2024-06-02 22:46:18', 1),
(6, 'juninho', '10 pras 6 manow', 'goncalves@gmail.com', '2024-06-02 22:51:38', 1),
(7, 'juninho', '10 pras 6 manow', 'goncalves@gmail.com', '2024-06-02 22:52:27', 1),
(8, 'hfhfg', 'fhfghfgh', 'gfhgfhfg@gmail.com', '2024-06-15 17:31:30', 0),
(9, 'luis', 'muito bom voce vai conseguir', 'luis@luis.com', '2024-06-18 21:16:34', 1),
(10, 'zé', 'testando comentario de zé', 'ze@gmail.com', '2024-06-18 21:42:15', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `senha` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`) VALUES
(3, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(4, 'joao', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
