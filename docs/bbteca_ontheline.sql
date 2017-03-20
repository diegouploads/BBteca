-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Mar-2017 às 01:21
-- Versão do servidor: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbteca_ontheline`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimos`
--

CREATE TABLE `emprestimos` (
  `cod_controle` int(11) NOT NULL,
  `id_leitor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `data_emprestimo` date NOT NULL,
  `status` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `emprestimos`
--

INSERT INTO `emprestimos` (`cod_controle`, `id_leitor`, `idusuario`, `data_emprestimo`, `status`) VALUES
(19, 4, 1, '2017-03-08', '1'),
(20, 5, 1, '2017-03-08', '1'),
(21, 4, 1, '2017-03-08', '1'),
(22, 4, 1, '2017-03-17', '1'),
(23, 5, 1, '2017-03-17', '1'),
(24, 4, 1, '2017-03-20', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimoslivros`
--

CREATE TABLE `emprestimoslivros` (
  `idlivro` int(11) NOT NULL,
  `idemprestimo` int(11) NOT NULL,
  `multa_atraso_pg` decimal(15,0) NOT NULL,
  `qtd_emprestado` int(5) NOT NULL,
  `data_previa` datetime NOT NULL,
  `data_devolvido` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `emprestimoslivros`
--

INSERT INTO `emprestimoslivros` (`idlivro`, `idemprestimo`, `multa_atraso_pg`, `qtd_emprestado`, `data_previa`, `data_devolvido`) VALUES
(4, 22, '0', 2, '2017-03-27 00:00:00', '2017-03-20 00:00:00'),
(5, 19, '0', 2, '2017-03-13 00:00:00', '2017-03-20 00:00:00'),
(5, 21, '0', 1, '2017-03-13 00:00:00', NULL),
(5, 23, '0', 2, '2017-03-22 00:00:00', NULL),
(5, 24, '0', 2, '2017-03-25 00:00:00', NULL),
(6, 20, '0', 4, '2017-03-20 00:00:00', NULL),
(6, 21, '0', 2, '2017-03-20 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `leitor`
--

CREATE TABLE `leitor` (
  `cod_leitor` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `endereco` varchar(30) NOT NULL,
  `num_endereco` varchar(12) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `leitor`
--

INSERT INTO `leitor` (`cod_leitor`, `nome`, `endereco`, `num_endereco`, `bairro`, `telefone`, `email`, `status`) VALUES
(4, 'Will Marcel', 'Av.Goias', '431', 'Centro', '44-3521-2166', 'will@teste.com', '1'),
(5, 'Diego', 'Rua Parana 100', '375', 'Centro', '4497116771', 'diego_ribeiro09@hotmail.com', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

CREATE TABLE `livros` (
  `cod_livro` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `editora` varchar(100) NOT NULL,
  `edicao` varchar(100) NOT NULL,
  `exemplares` int(11) NOT NULL,
  `multa_atraso` decimal(15,2) NOT NULL,
  `status` char(1) NOT NULL,
  `dias_dev` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `livros`
--

INSERT INTO `livros` (`cod_livro`, `titulo`, `autor`, `descricao`, `editora`, `edicao`, `exemplares`, `multa_atraso`, `status`, `dias_dev`) VALUES
(4, 'PHP 4: a biblia', 'PARK, Joyce', 'PHP - Linguagem', 'Rio de Janeiro: Campus, 2001', '3434', 30, '2.50', '1', 10),
(5, 'Professional PHP programando', 'CASTAGNETTO, Jesus...et al.', 'PHP - Linguagem', 'Sao Paulo', '4346', 12, '2.25', '1', 5),
(6, 'Aprendendo MySQL e PHP', 'BUYENS, Jim', 'PHP - Linguagem; MySQL - Linguagem', 'Sao Paulo: Makron Books, 2002', '564', 15, '1.75', '1', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `nome`, `email`, `senha`, `status`) VALUES
(1, 'admin', 'admin@admin.com', '123', '1'),
(4, 'User Padrao', 'padrao@admin.com', '123', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`cod_controle`),
  ADD KEY `user` (`idusuario`),
  ADD KEY `leitor` (`id_leitor`);

--
-- Indexes for table `emprestimoslivros`
--
ALTER TABLE `emprestimoslivros`
  ADD PRIMARY KEY (`idlivro`,`idemprestimo`) USING BTREE,
  ADD KEY `livroid` (`idlivro`),
  ADD KEY `emprestimoid` (`idemprestimo`) USING BTREE;

--
-- Indexes for table `leitor`
--
ALTER TABLE `leitor`
  ADD PRIMARY KEY (`cod_leitor`);

--
-- Indexes for table `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`cod_livro`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `cod_controle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `leitor`
--
ALTER TABLE `leitor`
  MODIFY `cod_leitor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `livros`
--
ALTER TABLE `livros`
  MODIFY `cod_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emprestimos_ibfk_2` FOREIGN KEY (`id_leitor`) REFERENCES `leitor` (`cod_leitor`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `emprestimoslivros`
--
ALTER TABLE `emprestimoslivros`
  ADD CONSTRAINT `emprestimoslivros_ibfk_1` FOREIGN KEY (`idemprestimo`) REFERENCES `emprestimos` (`cod_controle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emprestimoslivros_ibfk_2` FOREIGN KEY (`idlivro`) REFERENCES `livros` (`cod_livro`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
