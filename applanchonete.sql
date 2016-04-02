-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Abr-2016 às 02:55
-- Versão do servidor: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `applanchonete`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_permissao_insert`(IN `id` INT, IN `role_id` INT)
    NO SQL
BEGIN

DECLARE item_name VARCHAR(64);


CASE role_id 
WHEN 2
THEN set item_name = 'gerente';
WHEN 3
THEN set item_name = 'funcionario';
END CASE;

insert into auth_assignment (item_name, user_id) VALUES (item_name, id);


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 1, NULL),
('caixa', 84, NULL),
('compra', 84, NULL),
('compra', 85, NULL),
('create-compra', 85, NULL),
('create-fornecedor', 85, NULL),
('create-fornecedor', 104, NULL),
('create-fornecedor', 110, NULL),
('create-relatorio', 108, NULL),
('delete-compra', 85, NULL),
('delete-fornecedor', 85, NULL),
('delete-fornecedor', 104, NULL),
('delete-fornecedor', 110, NULL),
('delete-relatorio', 108, NULL),
('despesa', 84, NULL),
('fornecedor', 84, NULL),
('fornecedor', 85, NULL),
('fornecedor', 104, NULL),
('fornecedor', 110, NULL),
('index-compra', 85, NULL),
('index-fornecedor', 85, NULL),
('index-fornecedor', 104, NULL),
('index-fornecedor', 109, NULL),
('index-fornecedor', 110, NULL),
('index-relatorio', 108, NULL),
('index-user', 109, NULL),
('relatorio', 84, NULL),
('relatorio', 108, NULL),
('update-compra', 85, NULL),
('update-fornecedor', 85, NULL),
('update-fornecedor', 104, NULL),
('update-fornecedor', 110, NULL),
('update-relatorio', 108, NULL),
('user', 84, NULL),
('view-compra', 85, NULL),
('view-despesa', 104, NULL),
('view-fornecedor', 85, NULL),
('view-fornecedor', 104, NULL),
('view-fornecedor', 110, NULL),
('view-relatorio', 108, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin', NULL, NULL, NULL, NULL),
('caixa', 8, 'Caixa', NULL, NULL, NULL, NULL),
('compra', 26, 'Compra', NULL, NULL, NULL, NULL),
('create-caixa', 11, 'Criar Caixa', NULL, NULL, NULL, NULL),
('create-compra', 29, 'Criar Compra', NULL, NULL, NULL, NULL),
('create-despesa', 5, 'Criar Despesa', NULL, NULL, NULL, NULL),
('create-fornecedor', 17, 'Criar Fornecedor', NULL, NULL, NULL, NULL),
('create-relatorio', 23, 'Criar Relatório', NULL, NULL, NULL, NULL),
('create-user', 35, 'Criar Usuário', NULL, NULL, NULL, NULL),
('delete-caixa', 13, 'Deletar Caixa', NULL, NULL, NULL, NULL),
('delete-compra', 31, 'Deletar Compra', NULL, NULL, NULL, NULL),
('delete-despesa', 7, 'Deletar Despesa', NULL, NULL, NULL, NULL),
('delete-fornecedor', 19, 'Deletar Fornecedor', NULL, NULL, NULL, NULL),
('delete-relatorio', 25, 'Deletar Relatório', NULL, NULL, NULL, NULL),
('delete-user', 37, 'Deletar Usuário', NULL, NULL, NULL, NULL),
('despesa', 2, 'Despesa', NULL, NULL, NULL, NULL),
('fornecedor', 14, 'Fornecedor', NULL, NULL, NULL, NULL),
('index-caixa', 9, 'Listar Caixas', NULL, NULL, NULL, NULL),
('index-compra', 27, 'Listar Compras', NULL, NULL, NULL, NULL),
('index-despesa', 3, 'Listar Despesas', NULL, NULL, NULL, NULL),
('index-fornecedor', 15, 'Listar Fornecedores', NULL, NULL, NULL, NULL),
('index-relatorio', 21, 'Listar Relatórios', NULL, NULL, NULL, NULL),
('index-user', 33, 'Listar Usuários', NULL, NULL, NULL, NULL),
('relatorio', 20, 'Relatório', NULL, NULL, NULL, NULL),
('update-caixa', 12, 'Editar Caixa', NULL, NULL, NULL, NULL),
('update-compra', 30, 'Editar Compra', NULL, NULL, NULL, NULL),
('update-despesa', 6, 'Editar Despesa', NULL, NULL, NULL, NULL),
('update-fornecedor', 18, 'Editar Fornecedor', NULL, NULL, NULL, NULL),
('update-relatorio', 24, 'Editar Relatório', NULL, NULL, NULL, NULL),
('update-user', 36, 'Editar Usuário', NULL, NULL, NULL, NULL),
('user', 32, 'Usuário', NULL, NULL, NULL, NULL),
('view-caixa', 10, 'Visualizar Caixa', NULL, NULL, NULL, NULL),
('view-compra', 28, 'Visualizar Compra', NULL, NULL, NULL, NULL),
('view-despesa', 4, 'Visualizar Despesa', NULL, NULL, NULL, NULL),
('view-fornecedor', 16, 'Visualizar Fornecedor', NULL, NULL, NULL, NULL),
('view-relatorio', 22, 'Visualizar Relatório', NULL, NULL, NULL, NULL),
('view-user', 34, 'Visualizar Usuário', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('caixa', 'create-caixa'),
('compra', 'create-compra'),
('despesa', 'create-despesa'),
('fornecedor', 'create-fornecedor'),
('relatorio', 'create-relatorio'),
('user', 'create-user'),
('caixa', 'delete-caixa'),
('compra', 'delete-compra'),
('despesa', 'delete-despesa'),
('fornecedor', 'delete-fornecedor'),
('relatorio', 'delete-relatorio'),
('user', 'delete-user'),
('caixa', 'index-caixa'),
('compra', 'index-compra'),
('despesa', 'index-despesa'),
('fornecedor', 'index-fornecedor'),
('relatorio', 'index-relatorio'),
('user', 'index-user'),
('caixa', 'update-caixa'),
('compra', 'update-compra'),
('despesa', 'update-despesa'),
('fornecedor', 'update-fornecedor'),
('relatorio', 'update-relatorio'),
('user', 'update-user'),
('admin', 'user'),
('caixa', 'view-caixa'),
('compra', 'view-compra'),
('despesa', 'view-despesa'),
('fornecedor', 'view-fornecedor'),
('relatorio', 'view-relatorio'),
('user', 'view-user');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE IF NOT EXISTS `caixa` (
  `idcaixa` int(11) NOT NULL,
  `valorapurado` float NOT NULL,
  `valoremcaixa` double NOT NULL,
  `valorlucro` float NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`idcaixa`, `valorapurado`, `valoremcaixa`, `valorlucro`, `user_id`) VALUES
(4, 0.22, 0.22, 0.22, 84),
(6, 0.01, 0.02, 0.03, 109);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cardapio`
--

CREATE TABLE IF NOT EXISTS `cardapio` (
  `idCardapio` int(11) NOT NULL,
  `data` date NOT NULL,
  `titulo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nome`) VALUES
(3, 'Massa'),
(4, 'Legume'),
(5, 'Lanche');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

CREATE TABLE IF NOT EXISTS `comanda` (
  `idComanda` int(11) NOT NULL,
  `desconto` decimal(10,0) NOT NULL DEFAULT '0',
  `totalPago` decimal(10,0) NOT NULL,
  `dataHoraAbertura` datetime NOT NULL,
  `dataHoraFechamento` datetime NOT NULL,
  `descricao` text COMMENT 'Poder ser utilizado como descrição como também como ',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `totalPedidos` decimal(10,0) NOT NULL DEFAULT '0',
  `mesaIdMesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `datacompra` date NOT NULL,
  `totalcompra` float DEFAULT NULL,
  `idcompra` int(11) NOT NULL,
  `fornecedor_idFornecedor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `compra`
--

INSERT INTO `compra` (`datacompra`, `totalcompra`, `idcompra`, `fornecedor_idFornecedor`) VALUES
('2015-12-05', 0, 5, 1),
('2016-01-08', 22.22, 6, 1),
('2016-02-25', 1.23, 7, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesa`
--

CREATE TABLE IF NOT EXISTS `despesa` (
  `iddespesa` int(11) NOT NULL,
  `nomedespesa` varchar(100) NOT NULL,
  `valordespesa` float NOT NULL,
  `situacaopagamento` tinyint(1) NOT NULL,
  `datavencimento` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `despesa`
--

INSERT INTO `despesa` (`iddespesa`, `nomedespesa`, `valordespesa`, `situacaopagamento`, `datavencimento`) VALUES
(3, 'Água', 200, 1, '2015-12-30'),
(4, 'Luz', 123.12, 0, '2015-12-27'),
(5, 'Gás', 130, 0, '2015-12-31'),
(6, 'Teste', 2.31, 0, '2016-01-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `destaques`
--

CREATE TABLE IF NOT EXISTS `destaques` (
  `idDestaques` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `dataEntrada` datetime NOT NULL,
  `dataSaida` datetime NOT NULL,
  `link` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE IF NOT EXISTS `fornecedor` (
  `cnpj` varchar(18) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `idFornecedor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`cnpj`, `nome`, `endereco`, `idFornecedor`) VALUES
('11.111.111/1111-11', 'Supermercado', 'Rua Principal , 123', 1),
('22.222.222/2222-22', '123', '123', 2),
('33.333.333/3333-33', 'Atacado e Varejo', 'Rua Principal', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicosituacao`
--

CREATE TABLE IF NOT EXISTS `historicosituacao` (
  `idPedido` int(11) NOT NULL,
  `idSituacaoPedido` int(11) NOT NULL,
  `dataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `insumos`
--

CREATE TABLE IF NOT EXISTS `insumos` (
  `idprodutoVenda` int(11) NOT NULL,
  `idprodutoInsumo` int(11) NOT NULL,
  `quantidade` float NOT NULL,
  `unidade` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itemcardapio`
--

CREATE TABLE IF NOT EXISTS `itemcardapio` (
  `idCardapio` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ordem` int(11) DEFAULT NULL COMMENT 'ordem exibicao'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itempedido`
--

CREATE TABLE IF NOT EXISTS `itempedido` (
  `idPedido` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `quantidade` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL COMMENT 'Preço produto * quandida'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja`
--

CREATE TABLE IF NOT EXISTS `loja` (
  `endereco` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja`
--

INSERT INTO `loja` (`endereco`, `user_id`, `nome`) VALUES
('Rua Gerente', 44, 'Loja do Gerente'),
('Rua Central', 84, 'Lanchonete');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesa`
--

CREATE TABLE IF NOT EXISTS `mesa` (
  `idMesa` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `disponivel` tinyint(4) NOT NULL COMMENT 'Status da mesa como ocupado/livre',
  `alerta` tinyint(4) NOT NULL COMMENT 'Campo para geração do alerta\n, caso ele esteja ativado  gerará \numa idenficação visual para\n',
  `qrcode` varchar(100) NOT NULL COMMENT 'localização ',
  `chave` varchar(45) NOT NULL COMMENT 'chave da mesa, criada no momento da criação da mesma',
  `cont` int(11) NOT NULL DEFAULT '0' COMMENT 'valor de iniciação do algoritimo de chaves\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1453765314),
('m150214_044831_init_user', 1453765327);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE IF NOT EXISTS `pagamento` (
  `idPagamento` int(11) NOT NULL,
  `valor` decimal(10,0) NOT NULL DEFAULT '0',
  `dataHora` datetime NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `tipoPagamento_idTipoPagamento` int(11) NOT NULL,
  `idComanda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `idPedido` int(11) NOT NULL,
  `totalPedido` decimal(10,0) NOT NULL,
  `idSituacaoAtual` int(11) NOT NULL COMMENT 'Situação atual do staus do pedido, \nfacilitar na busca do status do pedido',
  `idComanda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `idProduto` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `valorVenda` float(10,0) NOT NULL,
  `isInsumo` tinyint(1) NOT NULL,
  `quantidadeMinima` float NOT NULL DEFAULT '0',
  `idCategoria` int(11) NOT NULL,
  `quantidadeEstoque` float DEFAULT '0' COMMENT 'Valor deve ser maior que 0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_compra`
--

CREATE TABLE IF NOT EXISTS `produtos_compra` (
  `idprodutos_compra` int(11) NOT NULL,
  `compra_idcompra` int(11) NOT NULL,
  `quantidade_produto` float NOT NULL,
  `estoque_idestoque` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `created_at`, `updated_at`, `full_name`) VALUES
(1, 1, '2016-01-26 02:42:07', '2016-01-28 01:27:25', 'Admin'),
(2, 2, '2016-01-26 20:58:10', '2016-01-28 01:17:46', ''),
(3, 3, '2016-01-26 21:02:42', '2016-01-31 04:37:09', ''),
(33, 43, '2016-02-01 01:00:46', '2016-02-01 04:23:48', ''),
(34, 44, '2016-02-01 01:01:26', '2016-02-01 01:01:26', NULL),
(59, 80, '2016-02-05 03:30:47', '2016-02-05 05:19:16', ''),
(63, 84, '2016-02-09 02:14:53', '2016-02-09 02:14:53', NULL),
(64, 85, '2016-02-10 06:13:27', '2016-02-13 17:20:37', ''),
(65, 104, '2016-02-14 05:09:25', '2016-02-14 06:02:05', ''),
(69, 108, '2016-02-14 06:30:37', '2016-02-14 06:30:37', ''),
(70, 109, '2016-02-14 22:38:19', '2016-03-02 04:26:23', ''),
(71, 110, '2016-03-02 04:30:57', '2016-03-02 04:49:11', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio`
--

CREATE TABLE IF NOT EXISTS `relatorio` (
  `idrelatorio` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `datageracao` date NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `inicio_intervalo` date DEFAULT NULL,
  `fim_intervalo` date NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `relatorio`
--

INSERT INTO `relatorio` (`idrelatorio`, `nome`, `datageracao`, `tipo`, `inicio_intervalo`, `fim_intervalo`, `usuario_id`) VALUES
(5, 'Relatório 01', '2016-02-01', 'Compras', '2016-01-26', '2016-01-30', 44),
(6, 'Relatório 02', '2016-02-09', 'Faturamento', '2016-02-25', '2016-02-29', 84),
(7, 'testestesteste', '2016-02-14', NULL, NULL, '2016-02-15', 109);

-- --------------------------------------------------------

--
-- Estrutura da tabela `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`, `can_admin`) VALUES
(1, 'Admin', '2016-01-26 02:42:06', NULL, 1),
(2, 'User', '2016-01-26 02:42:06', NULL, 0),
(3, 'Compras', '2016-01-26 03:00:00', '2016-01-26 03:00:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacaopedido`
--

CREATE TABLE IF NOT EXISTS `situacaopedido` (
  `idSituacaoPedido` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` text NOT NULL COMMENT 'ESTARA INCLUSO NA TABELA DE SISTEMA\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipopagamento`
--

CREATE TABLE IF NOT EXISTS `tipopagamento` (
  `idTipoPagamento` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `banned_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `username`, `password`, `auth_key`, `access_token`, `logged_in_ip`, `logged_in_at`, `created_ip`, `created_at`, `updated_at`, `banned_at`, `banned_reason`) VALUES
(1, 1, 1, 'admin@sigir.com', 'admin', '$2y$13$ZaQ4eZwz1ZevK9oaKksT2uKcUlh1aytLRyqGGUGYJSzNLuBcYJOvO', '4c1Lk1bFV-2gSyrQnXm7661avqoQOC0L', 'W6ELUzLx6Zvva8fQ5NV4nLl8jJInF_BC', '::1', '2016-03-22 15:32:27', NULL, '2016-01-26 02:42:06', '2016-01-28 01:27:25', NULL, NULL),
(2, 2, 1, 'gerente@sigir.com', 'gerente2', '$2y$13$SVYrr6CicYYdpMnep5LKtO8ak84X8h6tFHYVpR8j7nGupVOvqnpVa', 'VPd_SzxMvyTgZprvDA-tfT4kPW_IYzZD', 'UyNFyd41oMBIiRVurZPZuvt6kgTe98xy', '::1', '2016-02-07 23:58:31', '::1', '2016-01-26 20:58:10', '2016-01-31 01:28:29', NULL, NULL),
(3, 3, 1, 'funcionario@sigir.com', 'funcionario', '$2y$13$.gl9ePCdOVOww1C7AZosD.GSsbD6cMERou36tWYrmEN.dtEFkml9i', 't6g9cyhdz2-EKqG3Whb6TC30qNPQ6oU7', 'BAWIuKS9sXShdh2fM3QnwH8ZqdT5mGwv', '::1', '2016-02-02 05:21:59', '::1', '2016-01-26 21:02:42', '2016-01-31 04:37:09', NULL, NULL),
(43, 3, 1, 'funcionario1@sigir.com', 'funcionario01', '$2y$13$MR/pQJFMZRJZkZj4.xg0qOtdjJK6NMaMo5jF4bVt1tPHf7sjr0QHi', 'JoIVj9p9IWlVklx1TZ00otnbcr-Gmao7', 'hAYvnkL8pFzP6FGMH7eKw7UmisflzyjX', '::1', '2016-02-05 03:48:25', '::1', '2016-02-01 01:00:46', '2016-02-01 04:23:48', NULL, NULL),
(44, 2, 1, 'gerente1@sigir.com', 'gerente', '$2y$13$mujgA7j0OsPxUr0gYAao3OSk1yykiEFfxqXis7m.lzvZ3EWID1jOG', 'c4rPsYI-Q-WNI9GgYyTvbZr_ynwyuAlY', 'nAzvxmIB3bTRTW9d23dn1isBFBr6s7RI', '::1', '2016-02-09 23:37:54', '::1', '2016-02-01 01:01:26', '2016-02-09 07:11:09', NULL, NULL),
(80, 2, 1, 'teste@teste.com', NULL, '$2y$13$Up2wVYVIsBKk3oij/H/8l.5hPym80.3NTFpGlc97cSJg32EqNGn4y', 'EXAFyYZpG5QVTcGx6yeFrlDOl9OizMuM', 'ZdjGbu9FKlXtF5mYt1A4CcShpkEaTd9i', '::1', '2016-02-08 01:22:20', '::1', '2016-02-05 03:30:47', '2016-02-05 05:19:16', NULL, NULL),
(84, 2, 1, 'user@master.com', NULL, '$2y$13$hiUnt5bM5nC02ntGxCCmBesZZIFNs5p/pfQ2ZNtNTvUdFcDGr5ZCa', 'RdSnQjSZqz7Z2_bQUTFgmbJAhug45hFL', '38W0FnvUuYydns3nmlBagAIpH2R3NQuY', '::1', '2016-03-22 15:32:50', '::1', '2016-02-09 02:14:53', '2016-02-09 02:14:53', NULL, NULL),
(85, 2, 1, 'compras@compras.com', 'Compra', '$2y$13$fcSVvuFUmhH.3iZ0wTtoZOpkVTt1tjAg2fO2thZog9QwMUIEUUzKu', 'tVH-bh0RpqSA1RgMqIR4rqcKtKiGhvPB', '165xJKTAkwnR1QcUd6wQ-fkU8Q98od2O', '::1', '2016-02-12 04:37:12', '::1', '2016-02-10 06:13:27', '2016-02-13 17:20:37', NULL, NULL),
(104, 2, 1, 'teste3@teste.com', 'teste3', '$2y$13$4MrmhHyYwYzQ5uFHtr8rpeUNCgFCZiHR0410sdcJBABbm/zl/1Z..', 'ndzPwraET0uG3RZMtH23_-7IdxZtiRaH', 'nO74vFAzRakvIVNVrrJLrl4CU9718fzh', '::1', '2016-02-14 05:59:05', '::1', '2016-02-14 05:09:25', '2016-02-14 06:02:05', NULL, NULL),
(108, 2, 1, 'teste4@teste.com', 'teste44', '$2y$13$COZu07CnXAVlfSQJwK6ng.LnOd43dGyN29Tw/FH13Mtoa/zTtlGwy', 'Hs7QEYX6yxldLcpIVPjwNoBNBY5zWDSa', 'Ib_71XRL0h05Yr1STAjJwv9Y3sfJOIW4', '::1', '2016-02-14 06:35:23', '::1', '2016-02-14 06:30:37', '2016-02-14 06:35:48', NULL, NULL),
(109, 2, 1, 'teste5@teste.com', 'te5te', '$2y$13$kmvcINGlBELnlIkODn5jROZn1j9YaK6gUOgE1d1hLgVRK0Div9ZDC', 'qhwHHhEN3dUbQlbS-KgD0s-FeCaEHWN8', 'bjaxj0OwAYpBgPGkY-8IiQz6078n-lHd', '::1', '2016-03-02 04:25:06', '::1', '2016-02-14 22:38:19', '2016-03-02 04:26:23', NULL, NULL),
(110, 2, 1, 'teste6@teste.com', NULL, '$2y$13$HqbxlWNZCTEvklWOT0qe3.6SzPXRnw8Dw5NUvzwZbbRNUux6iRD0e', 'qu8OL_HN7TxFAYp8EQ1aUet-ApaO3ayK', '8ui-NK4VbPSmS6uTSBbLeiByU8ZSeOuj', '::1', '2016-03-02 04:33:26', '::1', '2016-03-02 04:30:57', '2016-03-02 04:49:11', NULL, NULL);

--
-- Acionadores `user`
--
DELIMITER $$
CREATE TRIGGER `add_permissao_trigger_insert` AFTER INSERT ON `user`
 FOR EACH ROW BEGIN
/*call add_permissao_insert(NEW.id,NEW.role_id);*/
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_token`
--

CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `type`, `token`, `data`, `created_at`, `expired_at`) VALUES
(1, NULL, 1, 'sCEWROGD-OXtwPRJUDdjbpbWPdvTo4kI', NULL, '2016-02-04 04:17:24', NULL),
(2, 3, 1, 'oEkaTVP0ZBfdzI-XY6IlHPUCehvSv-ev', NULL, '2016-01-26 21:02:42', NULL),
(32, 43, 1, '-mYarXbf4qriJlTT2763Ozr40yyKpWZF', NULL, '2016-02-01 01:00:46', NULL),
(33, 44, 1, 'HilWUVjTxlxgzqtA2KBRtL9bP3FcbkZn', NULL, '2016-02-01 01:01:26', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `loja_nome` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`), ADD KEY `rule_name` (`rule_name`), ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`), ADD KEY `auth_item_child_ibfk_2` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`idcaixa`), ADD KEY `caixa_ibfk_1` (`user_id`);

--
-- Indexes for table `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`idCardapio`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indexes for table `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`idComanda`), ADD KEY `fk_comanda_mesa1_idx` (`mesaIdMesa`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`), ADD KEY `fk_compra_fornecedor1` (`fornecedor_idFornecedor`);

--
-- Indexes for table `despesa`
--
ALTER TABLE `despesa`
  ADD PRIMARY KEY (`iddespesa`);

--
-- Indexes for table `destaques`
--
ALTER TABLE `destaques`
  ADD PRIMARY KEY (`idDestaques`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`idFornecedor`), ADD UNIQUE KEY `cnpj_UNIQUE` (`cnpj`);

--
-- Indexes for table `historicosituacao`
--
ALTER TABLE `historicosituacao`
  ADD PRIMARY KEY (`idPedido`,`idSituacaoPedido`), ADD KEY `fk_historioSituacao_situacaoPedido1_idx` (`idSituacaoPedido`);

--
-- Indexes for table `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`idprodutoVenda`);

--
-- Indexes for table `itemcardapio`
--
ALTER TABLE `itemcardapio`
  ADD PRIMARY KEY (`idCardapio`,`idProduto`), ADD KEY `fk_itemcardapio_produto1_idx` (`idProduto`);

--
-- Indexes for table `itempedido`
--
ALTER TABLE `itempedido`
  ADD PRIMARY KEY (`idPedido`,`idProduto`), ADD KEY `fk_itemPedido_produto1_idx` (`idProduto`);

--
-- Indexes for table `loja`
--
ALTER TABLE `loja`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`idPagamento`), ADD KEY `fk_pagamento_tipoPagamento1_idx` (`tipoPagamento_idTipoPagamento`), ADD KEY `fk_pagamento_comanda1_idx` (`idComanda`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`), ADD KEY `fk_pedido_situacaoPedido1_idx` (`idSituacaoAtual`), ADD KEY `fk_pedido_comanda1_idx` (`idComanda`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`), ADD KEY `fk_produto_categoria1_idx` (`idCategoria`);

--
-- Indexes for table `produtos_compra`
--
ALTER TABLE `produtos_compra`
  ADD PRIMARY KEY (`idprodutos_compra`), ADD KEY `fk_produtos_compra_compra1` (`compra_idcompra`), ADD KEY `fk_produtos_compra_estoque1` (`estoque_idestoque`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`), ADD KEY `profile_user_id` (`user_id`);

--
-- Indexes for table `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`idrelatorio`), ADD KEY `fk_relatorio_usuario1` (`usuario_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `situacaopedido`
--
ALTER TABLE `situacaopedido`
  ADD PRIMARY KEY (`idSituacaoPedido`);

--
-- Indexes for table `tipopagamento`
--
ALTER TABLE `tipopagamento`
  ADD PRIMARY KEY (`idTipoPagamento`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_email` (`email`), ADD UNIQUE KEY `user_username` (`username`), ADD KEY `user_role_id` (`role_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`), ADD KEY `user_auth_provider_id` (`provider_id`), ADD KEY `user_auth_user_id` (`user_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_token_token` (`token`), ADD KEY `user_token_user_id` (`user_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`), ADD KEY `fk_usuario_loja1` (`loja_nome`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caixa`
--
ALTER TABLE `caixa`
  MODIFY `idcaixa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `idCardapio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `comanda`
--
ALTER TABLE `comanda`
  MODIFY `idComanda` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `despesa`
--
ALTER TABLE `despesa`
  MODIFY `iddespesa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `idFornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `idPagamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `produtos_compra`
--
ALTER TABLE `produtos_compra`
  MODIFY `idprodutos_compra` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `idrelatorio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `situacaopedido`
--
ALTER TABLE `situacaopedido`
  MODIFY `idSituacaoPedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipopagamento`
--
ALTER TABLE `tipopagamento`
  MODIFY `idTipoPagamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `auth_assignment_ibfk_3` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `auth_rule`
--
ALTER TABLE `auth_rule`
ADD CONSTRAINT `auth_rule_ibfk_1` FOREIGN KEY (`name`) REFERENCES `auth_item` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `caixa`
--
ALTER TABLE `caixa`
ADD CONSTRAINT `caixa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `comanda`
--
ALTER TABLE `comanda`
ADD CONSTRAINT `fk_comanda_mesa10` FOREIGN KEY (`mesaIdMesa`) REFERENCES `mesa` (`idMesa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `compra`
--
ALTER TABLE `compra`
ADD CONSTRAINT `fk_compra_fornecedor1` FOREIGN KEY (`fornecedor_idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `historicosituacao`
--
ALTER TABLE `historicosituacao`
ADD CONSTRAINT `fk_historioSituacao_pedido10` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_historioSituacao_situacaoPedido10` FOREIGN KEY (`idSituacaoPedido`) REFERENCES `situacaopedido` (`idSituacaoPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `insumos`
--
ALTER TABLE `insumos`
ADD CONSTRAINT `insumos_ibfk_1` FOREIGN KEY (`idprodutoVenda`) REFERENCES `produto` (`idProduto`);

--
-- Limitadores para a tabela `itemcardapio`
--
ALTER TABLE `itemcardapio`
ADD CONSTRAINT `fk_itemcardapio_cardapio0` FOREIGN KEY (`idCardapio`) REFERENCES `cardapio` (`idCardapio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_itemcardapio_produto10` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `itempedido`
--
ALTER TABLE `itempedido`
ADD CONSTRAINT `fk_itemPedido_pedido10` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_itemPedido_produto10` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `loja`
--
ALTER TABLE `loja`
ADD CONSTRAINT `loja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
ADD CONSTRAINT `fk_pagamento_comanda10` FOREIGN KEY (`idComanda`) REFERENCES `comanda` (`idComanda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pagamento_tipoPagamento10` FOREIGN KEY (`tipoPagamento_idTipoPagamento`) REFERENCES `tipopagamento` (`idTipoPagamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
ADD CONSTRAINT `fk_pedido_comanda10` FOREIGN KEY (`idComanda`) REFERENCES `comanda` (`idComanda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_situacaoPedido10` FOREIGN KEY (`idSituacaoAtual`) REFERENCES `situacaopedido` (`idSituacaoPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
ADD CONSTRAINT `fk_produto_categoria10` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos_compra`
--
ALTER TABLE `produtos_compra`
ADD CONSTRAINT `fk_produtos_compra_compra1` FOREIGN KEY (`compra_idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `profile`
--
ALTER TABLE `profile`
ADD CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `relatorio`
--
ALTER TABLE `relatorio`
ADD CONSTRAINT `fk_relatorio_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Limitadores para a tabela `user_auth`
--
ALTER TABLE `user_auth`
ADD CONSTRAINT `user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `user_token`
--
ALTER TABLE `user_token`
ADD CONSTRAINT `user_token_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
