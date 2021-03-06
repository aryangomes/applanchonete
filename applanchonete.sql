-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 01-Set-2016 às 23:07
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `applanchonete`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_permissao_insert` (IN `id` INT, IN `role_id` INT)  NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `adicionaupdate_qtdprodutoestoque` (IN `idProdutoCompra` INT, IN `novaqtd` FLOAT, IN `antigaqtd` FLOAT)  NO SQL
BEGIN

DECLARE auxqtd ,
 diferenca float;

SELECT quantidadeEstoque into auxqtd from produto where produto.idProduto = idProdutoCompra;



IF novaqtd > antigaqtd THEN
set diferenca = novaqtd - antigaqtd;
UPDATE produto set quantidadeEstoque = (quantidadeEstoque + diferenca) WHERE produto.idProduto = idProdutoCompra;
else
set diferenca = antigaqtd - novaqtd ;
UPDATE produto set quantidadeEstoque = (quantidadeEstoque - diferenca) WHERE produto.idProduto = idProdutoCompra;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `adiciona_qtdprodutoestoque` (IN `idProdutoCompra` INT, IN `novaqtd` FLOAT)  NO SQL
BEGIN

UPDATE produto set quantidadeEstoque = (quantidadeEstoque + novaqtd) WHERE produto.idProduto = idProdutoCompra;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaContaPedido` (IN `iddoPedido` INT, IN `total` FLOAT)  NO SQL
BEGIN
DECLARE idconta int;

SELECT idConta into idconta from pagamento where pagamento.idPedido = iddoPedido;


update conta set valor = total where idConta = idconta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaQtdInsumoNoEstoque` (IN `idProdVnd` INT, IN `qtdProdutoVenda` INT)  NO SQL
BEGIN
declare
idproduto_insumo,idproduto_venda int;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTotalContaUpdate` (IN `iddoPedido` INT)  NO SQL
BEGIN

DECLARE 
idcta int;
DECLARE totalped float;

SELECT DISTINCT totalPedido into totalped from pedido where pedido.idPedido = iddoPedido;


SELECT DISTINCT idconta into idcta from pagamento where pagamento.idPedido = iddoPedido;

UPDATE conta set valor = totalped where idconta = idcta;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTotalPedidoDelete` (IN `iddoPedido` INT, IN `totalProduto` FLOAT)  NO SQL
BEGIN

UPDATE pedido set totalPedido = (totalPedido- totalProduto) WHERE idPedido = iddoPedido;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTotalPedidoInsert` (IN `iddoPedido` INT, IN `totalProduto` FLOAT)  NO SQL
BEGIN



UPDATE pedido set totalPedido = (totalPedido + totalProduto) WHERE idPedido = iddoPedido;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTotalPedidoUpdate` (IN `iddoPedido` INT, IN `totalProduto` FLOAT, IN `oldTotalProduto` FLOAT)  NO SQL
BEGIN

IF (totalProduto > oldTotalProduto) THEN
UPDATE pedido set totalPedido = (totalPedido + (totalProduto - oldTotalProduto )) WHERE idPedido = iddoPedido;
ELSEIF(totalProduto < oldTotalProduto) THEN 
UPDATE pedido set totalPedido = (totalPedido - (oldTotalProduto - totalProduto )) WHERE idPedido = iddoPedido;

END IF;





END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteContaPedido` (IN `iddaConta` INT)  NO SQL
BEGIN

DECLARE  iddoPedido int;
DECLARE auxidpedido int;

SELECT idPedido into iddoPedido from pagamento where idconta = iddaConta;


SELECT idPedido into auxidpedido from pedido where idPedido = iddoPedido;

if auxidpedido is not null then
DELETE FROM pedido where idPedido = iddoPedido;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePedidoConta` (IN `iddoPedido` INT)  NO SQL
BEGIN
declare iddaconta int;
DECLARE auxidconta int;

SELECT idconta INTO iddaconta from pagamento WHERE idPedido = iddoPedido;

SELECT idconta INTO auxidconta from conta WHERE idconta = iddaconta;

IF auxidconta is not null then 
DELETE from conta where idconta = iddaconta;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insereContaAPagar` (IN `iddaconta` INT, IN `datacompra` DATE)  NO SQL
BEGIN
INSERT INTO contasapagar (idconta) VALUES (iddaconta);


UPDATE conta SET descricao = concat("Compra de " , datacompra) WHERE idconta = iddaconta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insereContaPedido` (IN `idPedido` INT)  NO SQL
BEGIN


INSERT INTO conta (descricao,tipoConta) VALUES ('Pedido','contasareceber');

INSERT INTO pagamento (idConta,idPedido) VALUES (LAST_INSERT_ID(), idPedido);


INSERT INTO contasareceber (idconta) VALUES (LAST_INSERT_ID());

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 1, NULL),
('caixa', 43, NULL),
('caixa', 84, NULL),
('caixa', 115, NULL),
('caixa', 116, NULL),
('cardapio', 84, NULL),
('categoria', 84, NULL),
('compra', 84, NULL),
('compra', 85, NULL),
('compra', 108, NULL),
('create-compra', 85, NULL),
('create-fornecedor', 85, NULL),
('create-fornecedor', 104, NULL),
('create-relatorio', 108, NULL),
('definirvalorprodutovenda', 84, NULL),
('delete-compra', 85, NULL),
('delete-fornecedor', 85, NULL),
('delete-fornecedor', 104, NULL),
('delete-relatorio', 108, NULL),
('fornecedor', 84, NULL),
('fornecedor', 85, NULL),
('fornecedor', 104, NULL),
('fornecedor', 116, NULL),
('index-caixa', 84, NULL),
('index-compra', 85, NULL),
('index-fornecedor', 85, NULL),
('index-fornecedor', 104, NULL),
('index-pagamento', 109, NULL),
('index-relatorio', 85, NULL),
('index-relatorio', 115, NULL),
('index-user', 109, NULL),
('insumo', 84, NULL),
('itempedido', 84, NULL),
('pedido', 84, NULL),
('produto', 84, NULL),
('produtosvenda', 84, NULL),
('relatorio', 43, NULL),
('relatorio', 84, NULL),
('relatorio', 85, NULL),
('update-compra', 85, NULL),
('update-fornecedor', 85, NULL),
('update-fornecedor', 104, NULL),
('update-relatorio', 108, NULL),
('user', 84, NULL),
('view-compra', 85, NULL),
('view-fornecedor', 85, NULL),
('view-fornecedor', 104, NULL),
('view-relatorio', 85, NULL),
('view-relatorio', 108, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

CREATE TABLE `auth_item` (
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
('avaliacaoproduto', 87, 'Avaliar Produto', NULL, NULL, NULL, NULL),
('caixa', 2, 'Caixa', NULL, NULL, NULL, NULL),
('cardapio', 32, 'Cardapio', NULL, NULL, NULL, NULL),
('categoria', 99, 'Categorias', NULL, NULL, NULL, NULL),
('compra', 20, 'Compra', NULL, NULL, NULL, NULL),
('conta', 111, 'Conta', NULL, NULL, NULL, NULL),
('contasapagar', 117, 'Conta a pagar', NULL, NULL, NULL, NULL),
('contasareceber', 123, 'Conta a receber', NULL, NULL, NULL, NULL),
('create-caixa', 5, 'Criar Caixa', NULL, NULL, NULL, NULL),
('create-cardapio', 36, 'Criar Cardapio', NULL, NULL, NULL, NULL),
('create-categoria', 101, 'Criar Categoria', NULL, NULL, NULL, NULL),
('create-compra', 23, 'Criar Compra', NULL, NULL, NULL, NULL),
('create-conta', 113, 'Criar Conta', NULL, NULL, NULL, NULL),
('create-contasapagar', 119, 'Criar Conta a pagar', NULL, NULL, NULL, NULL),
('create-contasareceber', 125, 'Criar Conta a receber', NULL, NULL, NULL, NULL),
('create-destaque', 40, 'Criar Destaque', NULL, NULL, NULL, NULL),
('create-fornecedor', 11, 'Criar Fornecedor', NULL, NULL, NULL, NULL),
('create-historicosituacao', 46, 'Criar Histórico de Situação', NULL, NULL, NULL, NULL),
('create-insumo', 95, 'Criar Insumos', NULL, NULL, NULL, NULL),
('create-itemcardapio', 52, 'Criar Item-Cardapio', NULL, NULL, NULL, NULL),
('create-itempedido', 107, 'Criar Item Pedido', NULL, NULL, NULL, NULL),
('create-loja', 58, 'Criar Loja', NULL, NULL, NULL, NULL),
('create-mesa', 64, 'Criar Mesa', NULL, NULL, NULL, NULL),
('create-pagamento', 70, 'Criar Pagamento', NULL, NULL, NULL, NULL),
('create-pedido', 76, 'Criar Pedido', NULL, NULL, NULL, NULL),
('create-produto', 82, 'Criar Produto', NULL, NULL, NULL, NULL),
('create-relatorio', 17, 'Criar Relatório', NULL, NULL, NULL, NULL),
('create-user', 29, 'Criar Usuário', NULL, NULL, NULL, NULL),
('definirvalorprodutovenda', 92, 'Definir valor de venda de Produto Venda', NULL, NULL, NULL, NULL),
('delete-caixa', 7, 'Deletar Caixa', NULL, NULL, NULL, NULL),
('delete-cardapio', 35, 'Deletar Cardapio', NULL, NULL, NULL, NULL),
('delete-categoria', 104, 'Deletar Categoria', NULL, NULL, NULL, NULL),
('delete-compra', 25, 'Deletar Compra', NULL, NULL, NULL, NULL),
('delete-conta', 116, 'Deletar Conta', NULL, NULL, NULL, NULL),
('delete-contasapagar', 122, 'Deletar Conta a pagar', NULL, NULL, NULL, NULL),
('delete-contasareceber', 128, 'Deletar Conta a receber', NULL, NULL, NULL, NULL),
('delete-destaque', 39, 'Deletar Destaque', NULL, NULL, NULL, NULL),
('delete-fornecedor', 13, 'Deletar Fornecedor', NULL, NULL, NULL, NULL),
('delete-historicosituacao', 45, 'Deletar Histórico Situação', NULL, NULL, NULL, NULL),
('delete-insumo', 98, 'Deletar Insumos', '', '', 0, NULL),
('delete-itemcardapio', 51, 'Delete Item-Cardapio', NULL, NULL, NULL, NULL),
('delete-itempedido', 110, 'Deletar Item Pedido', NULL, NULL, NULL, NULL),
('delete-loja', 57, 'Deletar Loja', NULL, NULL, NULL, NULL),
('delete-mesa', 63, 'Deletar Mesa', NULL, NULL, NULL, NULL),
('delete-pagamento', 69, 'Deletar Pagamento', NULL, NULL, NULL, NULL),
('delete-pedido', 75, 'Deletar Pedido', NULL, NULL, NULL, NULL),
('delete-produto', 81, 'Deletar Produto', NULL, NULL, NULL, NULL),
('delete-relatorio', 19, 'Deletar Relatório', NULL, NULL, NULL, NULL),
('delete-user', 31, 'Deletar Usuário', NULL, NULL, NULL, NULL),
('destaque', 38, 'Destaque', NULL, NULL, NULL, NULL),
('fornecedor', 8, 'Fornecedor', NULL, NULL, NULL, NULL),
('historicosituacao', 44, 'Historico Situação', NULL, NULL, NULL, NULL),
('index-caixa', 3, 'Listar Caixas', NULL, NULL, NULL, NULL),
('index-cardapio', 34, 'Listar Cardapio', NULL, NULL, NULL, NULL),
('index-categoria', 100, 'Listar Categorias', NULL, NULL, NULL, NULL),
('index-compra', 21, 'Listar Compras', NULL, NULL, NULL, NULL),
('index-conta', 112, 'Listar Contas', NULL, NULL, NULL, NULL),
('index-contasapagar', 118, 'Listar Contas a pagar', NULL, NULL, NULL, NULL),
('index-contasareceber', 124, 'Listar Contas a receber', NULL, NULL, NULL, NULL),
('index-destaque', 41, 'Listar Destaques', NULL, NULL, NULL, NULL),
('index-fornecedor', 9, 'Listar Fornecedores', NULL, NULL, NULL, NULL),
('index-historicosituacao', 47, 'Listar Histórico de Situação', NULL, NULL, NULL, NULL),
('index-insumo', 94, 'Listar Insumos', NULL, NULL, NULL, NULL),
('index-itemcardapio', 53, 'Listar Item-Cardapio', NULL, NULL, NULL, NULL),
('index-itempedido', 106, 'Listar Item Pedido', NULL, NULL, NULL, NULL),
('index-loja', 59, 'Listar Lojas', NULL, NULL, NULL, NULL),
('index-mesa', 65, 'Listar Mesas', NULL, NULL, NULL, NULL),
('index-pagamento', 71, 'Listar Pagamentos', NULL, NULL, NULL, NULL),
('index-pedido', 77, 'Listar Pedidos', NULL, NULL, NULL, NULL),
('index-produto', 83, 'Listar Produtos', NULL, NULL, NULL, NULL),
('index-relatorio', 15, 'Listar Relatórios', NULL, NULL, NULL, NULL),
('index-user', 27, 'Listar Usuários', NULL, NULL, NULL, NULL),
('insumo', 93, 'Insumos', NULL, NULL, NULL, NULL),
('itemcardapio', 50, 'Item Cardapio', NULL, NULL, NULL, NULL),
('itempedido', 105, 'Item Pedido', NULL, NULL, NULL, NULL),
('listadeinsumos', 86, 'Listar Insumos', NULL, NULL, NULL, NULL),
('listadeprodutosporinsumo', 88, 'Listar Produtos de Venda por Insumo', NULL, NULL, NULL, NULL),
('loja', 56, 'Loja', NULL, NULL, NULL, NULL),
('mesa', 62, 'Mesa', NULL, NULL, NULL, NULL),
('pagamento', 68, 'Pagamento', NULL, NULL, NULL, NULL),
('pedido', 74, 'Pedido', NULL, NULL, NULL, NULL),
('produto', 80, 'Produto', NULL, NULL, NULL, NULL),
('produtosvenda', 89, 'Listar Produtos Venda', NULL, NULL, NULL, NULL),
('relatorio', 14, 'Relatório', NULL, NULL, NULL, NULL),
('update-caixa', 6, 'Editar Caixa', NULL, NULL, NULL, NULL),
('update-cardapio', 37, 'Atualizar Caradapio', NULL, NULL, NULL, NULL),
('update-categoria', 103, 'Atualizar Categoria', NULL, NULL, NULL, NULL),
('update-compra', 24, 'Editar Compra', NULL, NULL, NULL, NULL),
('update-conta', 115, 'Atualizar Conta', NULL, NULL, NULL, NULL),
('update-contasapagar', 121, 'Atualizar Conta a pagar', NULL, NULL, NULL, NULL),
('update-contasareceber', 127, 'Atualizar Conta a receber', NULL, NULL, NULL, NULL),
('update-destaque', 42, 'Atualizar Destaque', NULL, NULL, NULL, NULL),
('update-fornecedor', 12, 'Editar Fornecedor', NULL, NULL, NULL, NULL),
('update-historicosituacao', 48, 'Atualizar Histórico de Situação', NULL, NULL, NULL, NULL),
('update-insumo', 97, 'Atualizar Insumos', NULL, NULL, NULL, NULL),
('update-itemcardapio', 54, 'Atualizar Item-Cardapio', NULL, NULL, NULL, NULL),
('update-itempedido', 109, 'Atualizar Item Pedido', NULL, NULL, NULL, NULL),
('update-loja', 60, 'Atualizar Loja', NULL, NULL, NULL, NULL),
('update-mesa', 66, 'Atualizar Mesa', NULL, NULL, NULL, NULL),
('update-pagamento', 72, 'Atualizar Pagamento', NULL, NULL, NULL, NULL),
('update-pedido', 79, 'Atualizar Pedido', NULL, NULL, NULL, NULL),
('update-produto', 84, 'Atualizar Produto', NULL, NULL, NULL, NULL),
('update-relatorio', 18, 'Editar Relatório', NULL, NULL, NULL, NULL),
('update-user', 30, 'Editar Usuário', NULL, NULL, NULL, NULL),
('user', 26, 'Usuário', NULL, NULL, NULL, NULL),
('view-caixa', 4, 'Visualizar Caixa', NULL, NULL, NULL, NULL),
('view-cardapio', 33, 'Visualizar Cardapio', NULL, NULL, NULL, NULL),
('view-categoria', 102, 'Visualizar Categoria', NULL, NULL, NULL, NULL),
('view-compra', 22, 'Visualizar Compra', NULL, NULL, NULL, NULL),
('view-conta', 114, 'Visualizar Conta', NULL, NULL, NULL, NULL),
('view-contasapagar', 120, 'Visualizar Conta a pagar', NULL, NULL, NULL, NULL),
('view-contasareceber', 126, 'Visualizar Conta a receber', NULL, NULL, NULL, NULL),
('view-destaque', 43, 'Visualizar Destaque', NULL, NULL, NULL, NULL),
('view-fornecedor', 10, 'Visualizar Fornecedor', NULL, NULL, NULL, NULL),
('view-historicosituacao', 49, 'Listar Histórico de Situação', NULL, NULL, NULL, NULL),
('view-insumo', 96, 'Visualizar Insumos', NULL, NULL, NULL, NULL),
('view-itemcardapio', 55, 'Visualizar Item-Cardapio', NULL, NULL, NULL, NULL),
('view-itempedido', 108, 'Visualizar', NULL, NULL, NULL, NULL),
('view-loja', 61, 'Visualizar Loja', NULL, NULL, NULL, NULL),
('view-mesa', 67, 'Visualizar Mesa', NULL, NULL, NULL, NULL),
('view-pagamento', 73, 'Visualizar Pagamentos', NULL, NULL, NULL, NULL),
('view-pedido', 78, 'Visualizar Pedido', NULL, NULL, NULL, NULL),
('view-produto', 85, 'Visualizar Produto', NULL, NULL, NULL, NULL),
('view-relatorio', 16, 'Visualizar Relatório', NULL, NULL, NULL, NULL),
('view-user', 28, 'Visualizar Usuário', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'user'),
('caixa', 'create-caixa'),
('caixa', 'delete-caixa'),
('caixa', 'index-caixa'),
('caixa', 'update-caixa'),
('caixa', 'view-caixa'),
('cardapio', 'create-cardapio'),
('cardapio', 'delete-cardapio'),
('cardapio', 'index-cardapio'),
('cardapio', 'update-cardapio'),
('cardapio', 'view-cardapio'),
('categoria', 'create-categoria'),
('categoria', 'delete-categoria'),
('categoria', 'index-categoria'),
('categoria', 'update-categoria'),
('categoria', 'view-categoria'),
('compra', 'create-compra'),
('compra', 'delete-compra'),
('compra', 'index-compra'),
('compra', 'update-compra'),
('compra', 'view-compra'),
('conta', 'create-conta'),
('conta', 'delete-conta'),
('conta', 'index-conta'),
('conta', 'update-conta'),
('conta', 'view-conta'),
('contasapagar', 'create-contasapagar'),
('contasapagar', 'delete-contasapagar'),
('contasapagar', 'index-contasapagar'),
('contasapagar', 'update-contasapagar'),
('contasapagar', 'view-contasapagar'),
('contasareceber', 'create-contasareceber'),
('contasareceber', 'delete-contasareceber'),
('contasareceber', 'index-contasareceber'),
('contasareceber', 'update-contasareceber'),
('contasareceber', 'view-contasareceber'),
('despesa', 'create-despesa'),
('despesa', 'delete-despesa'),
('despesa', 'index-despesa'),
('despesa', 'update-despesa'),
('despesa', 'view-despesa'),
('destaque', 'create-destaque'),
('destaque', 'delete-destaque'),
('destaque', 'index-destaque'),
('destaque', 'update-destaque'),
('destaque', 'view-destaque'),
('fornecedor', 'create-fornecedor'),
('fornecedor', 'delete-fornecedor'),
('fornecedor', 'index-fornecedor'),
('fornecedor', 'update-fornecedor'),
('fornecedor', 'view-fornecedor'),
('historicosituacao', 'create-historicosituacao'),
('historicosituacao', 'delete-historicosituacao'),
('historicosituacao', 'index-historicosituacao'),
('historicosituacao', 'update-historicosituacao'),
('historicosituacao', 'view-historicosituacao'),
('insumo', 'create-insumo'),
('insumo', 'delete-insumo'),
('insumo', 'index-insumo'),
('insumo', 'update-insumo'),
('insumo', 'view-insumos'),
('itemcardapio', 'create-itemcardapio'),
('itemcardapio', 'delete-itemcardapio'),
('itemcardapio', 'index-itemcardapio'),
('itemcardapio', 'update-itemcardapio'),
('itemcardapio', 'view-itemcardapio'),
('itempedido', 'create-itempedido'),
('itempedido', 'delete-itempedido'),
('itempedido', 'index-itempedido'),
('itempedido', 'update-itempedido'),
('itempedido', 'view-itempedido'),
('loja', 'create-loja'),
('loja', 'delete-loja'),
('loja', 'index-loja'),
('loja', 'update-loja'),
('loja', 'view-loja'),
('mesa', 'create-mesa'),
('mesa', 'delete-mesa'),
('mesa', 'index-mesa'),
('mesa', 'update-mesa'),
('mesa', 'view-mesa'),
('pedido', 'create-pedido'),
('pedido', 'delete-pedido'),
('pedido', 'index-pedido'),
('pedido', 'update-pedido'),
('pedido', 'view-pedido'),
('produto', 'alterarprodutovenda'),
('produto', 'avaliacaoproduto'),
('produto', 'cadastrarprodutovenda'),
('produto', 'create-produto'),
('produto', 'definirvalorvenda'),
('produto', 'delete-produto'),
('produto', 'index-produto'),
('produto', 'listadeinsumos'),
('produto', 'listadeprodutosporinsumo'),
('produto', 'produtosvenda'),
('produto', 'update-produto'),
('produto', 'view-produto'),
('relatorio', 'create-relatorio'),
('relatorio', 'delete-relatorio'),
('relatorio', 'index-relatorio'),
('relatorio', 'update-relatorio'),
('relatorio', 'view-relatorio'),
('user', 'create-user'),
('user', 'delete-user'),
('user', 'index-user'),
('user', 'update-user'),
('user', 'view-user');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `idcaixa` int(11) NOT NULL,
  `valorapurado` float DEFAULT '0',
  `valoremcaixa` float DEFAULT '0',
  `valorlucro` float DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `dataabertura` date NOT NULL,
  `datafechamento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`idcaixa`, `valorapurado`, `valoremcaixa`, `valorlucro`, `user_id`, `dataabertura`, `datafechamento`) VALUES
(19, 0, 0, 0, 84, '2016-09-01', '2016-09-01'),
(20, 0, 0, 0, 84, '2016-09-01', '2016-09-01'),
(21, 18.87, 18.87, 0, 84, '2016-09-01', '2016-09-01'),
(22, 2.83, 2.83, 0, 84, '2016-09-02', '2016-09-03'),
(23, 2.66, 2.66, 0, 84, '2016-09-01', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `idCardapio` int(11) NOT NULL,
  `data` date NOT NULL,
  `titulo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nome`) VALUES
(3, 'Massa'),
(4, 'Legume'),
(5, 'Lanche'),
(6, 'Bebidas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

CREATE TABLE `compra` (
  `idconta` int(11) NOT NULL,
  `valor` double NOT NULL,
  `descricao` text,
  `tipoConta` varchar(50) NOT NULL,
  `situacaoPagamento` tinyint(1) NOT NULL,
  `dataVencimento` date DEFAULT NULL,
  `dataCompra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `compra`
--

INSERT INTO `compra` (`idconta`, `valor`, `descricao`, `tipoConta`, `situacaoPagamento`, `dataVencimento`, `dataCompra`) VALUES
(79, 0, NULL, '', 0, NULL, '2016-06-02'),
(80, 0, NULL, '', 0, NULL, '2016-06-05'),
(173, 0, NULL, '', 0, NULL, '2016-08-29'),
(194, 0, NULL, '', 0, NULL, '2016-09-01'),
(215, 0, NULL, '', 0, NULL, '2016-09-01'),
(216, 0, NULL, '', 0, NULL, '2016-09-01');

--
-- Acionadores `compra`
--
DELIMITER $$
CREATE TRIGGER `tgr_insereContaAPagar` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
CALL insereContaAPagar(new.idconta, new.dataCompra);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compraproduto`
--

CREATE TABLE `compraproduto` (
  `idCompra` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `quantidade` float NOT NULL,
  `valorCompra` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `compraproduto`
--

INSERT INTO `compraproduto` (`idCompra`, `idProduto`, `quantidade`, `valorCompra`) VALUES
(76, 7, 10, 5),
(76, 9, 10, 5),
(78, 7, 10, 5),
(78, 9, 10, 5),
(79, 9, 10, 5),
(80, 7, 10, 5),
(80, 9, 10, 5),
(80, 12, 10, 5),
(80, 13, 10, 5),
(80, 45, 10, 3),
(80, 46, 10, 3),
(173, 64, 1, 1),
(194, 9, 30, 30),
(215, 64, 10, 2.34),
(216, 66, 20, 3.21);

--
-- Acionadores `compraproduto`
--
DELIMITER $$
CREATE TRIGGER `trg_adiciona_qtdprodutoestoque` AFTER INSERT ON `compraproduto` FOR EACH ROW BEGIN
call adiciona_qtdprodutoestoque(NEW.idProduto,NEW.quantidade);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_adicionaupdate_qtdprodutoestoque` AFTER UPDATE ON `compraproduto` FOR EACH ROW BEGIN
call adicionaupdate_qtdprodutoestoque(NEW.idProduto,NEW.quantidade,OLD.quantidade);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `idconta` int(11) NOT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `descricao` text,
  `tipoConta` varchar(100) NOT NULL,
  `situacaoPagamento` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`idconta`, `valor`, `descricao`, `tipoConta`, `situacaoPagamento`) VALUES
(5, 1.23, 'Pedido', 'contasareceber', 0),
(6, 10.3100004196167, 'Água', 'contasapagar', 0),
(13, 5.67, 'receber', 'contasareceber', 0),
(14, 8.9, 'pagar', 'contasapagar', 0),
(77, 0, 'Compra de 2016-06-02', 'contasapagar', 0),
(78, 0, 'Compra de 2016-06-03', 'contasapagar', 0),
(79, 0, 'Compra de 2016-06-02', 'contasapagar', 0),
(80, 0, 'Compra de 2016-06-05', 'contasapagar', 0),
(81, 0, 'Pedido', 'contasareceber', 0),
(109, 5.67, '567', 'contasapagar', 0),
(110, 90.91, '90', 'contasareceber', 0),
(111, 4, 'Custo fixo', 'custofixo', 0),
(112, 4.35, '-', 'contasapagar', 0),
(113, 5.55, '--', 'contasapagar', 0),
(114, 5.55, 'Conta', 'contasapagar', 0),
(115, 6.57, '-=', 'contasareceber', 0),
(116, 4, '-', 'custofixo', 0),
(117, 4, '', 'custofixo', 0),
(121, 1.23, '-', 'contasareceber', 0),
(126, 0.61, '', 'contasareceber', 0),
(127, 0, 'Pedido', 'contasareceber', 0),
(167, 4.670000076293945, 'Pedido', 'contasareceber', 0),
(168, 3.75, 'Pedido', 'contasareceber', 0),
(173, 0, 'Compra de 2016-08-29', 'contasapagar', 0),
(180, 0, 'Pedido', 'contasareceber', 0),
(181, 3, 'Pedido', 'contasareceber', 0),
(182, 3, 'Pedido', 'contasareceber', 0),
(187, 2, 'Pedido', 'contasareceber', 0),
(191, 3, 'Pedido', 'contasareceber', 0),
(192, 6, 'Pedido', 'contasareceber', 0),
(193, 2, 'Pedido', 'contasareceber', 0),
(194, 0, 'Compra de 2016-09-01', 'contasapagar', 0),
(195, 13, 'Pedido', 'contasareceber', 0),
(196, 2, 'Pedido', 'contasareceber', 0),
(197, 2, 'Pedido', 'contasareceber', 0),
(198, 2, 'Pedido', 'contasareceber', 0),
(199, 5, 'Pedido', 'contasareceber', 0),
(209, 2.8299999237060547, 'Pedido', 'contasareceber', 0),
(210, 2.8299999237060547, 'Pedido', 'contasareceber', 0),
(211, 2.8299999237060547, 'Pedido', 'contasareceber', 0),
(212, 2.8299999237060547, 'Pedido', 'contasareceber', 0),
(213, 8.380000114440918, 'Pedido', 'contasareceber', 0),
(214, 2.8299999237060547, 'Pedido', 'contasareceber', 0),
(215, 0, 'Compra de 2016-09-01', 'contasapagar', 0),
(216, 0, 'Compra de 2016-09-01', 'contasapagar', 0),
(217, 2.6600000858306885, 'Pedido', 'contasareceber', 0);

--
-- Acionadores `conta`
--
DELIMITER $$
CREATE TRIGGER `tgr_deleteContaPedido` AFTER DELETE ON `conta` FOR EACH ROW BEGIN

call deleteContaPedido(OLD.idconta);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contasapagar`
--

CREATE TABLE `contasapagar` (
  `idconta` int(11) NOT NULL,
  `dataVencimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contasapagar`
--

INSERT INTO `contasapagar` (`idconta`, `dataVencimento`) VALUES
(6, '2016-04-30'),
(14, '2016-05-18'),
(77, NULL),
(78, NULL),
(79, NULL),
(80, NULL),
(109, '2016-06-25'),
(111, '2016-06-09'),
(112, '2016-07-07'),
(114, '2016-07-08'),
(116, '2016-06-30'),
(117, '2016-06-10'),
(173, NULL),
(194, NULL),
(215, NULL),
(216, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contasareceber`
--

CREATE TABLE `contasareceber` (
  `idconta` int(11) NOT NULL,
  `dataHora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contasareceber`
--

INSERT INTO `contasareceber` (`idconta`, `dataHora`) VALUES
(5, '2016-05-12 00:00:00'),
(13, '2016-05-19 20:55:00'),
(81, '2016-05-23 00:56:50'),
(110, '2016-07-02 15:10:00'),
(115, '2016-06-11 03:15:00'),
(126, '2016-07-22 23:55:00'),
(127, '2016-07-16 23:25:19'),
(167, '2016-08-06 14:49:57'),
(168, '2016-08-12 10:21:20'),
(170, '2016-08-13 10:26:53'),
(172, '2016-08-13 10:44:36'),
(180, '2016-08-31 22:43:40'),
(181, '2016-08-31 23:14:13'),
(182, '2016-08-31 23:17:14'),
(187, '2016-08-31 23:43:17'),
(191, '2016-08-31 23:48:04'),
(192, '2016-08-31 23:48:28'),
(193, '2016-09-01 10:17:20'),
(195, '2016-09-01 10:25:35'),
(196, '2016-09-01 10:29:27'),
(197, '2016-09-01 11:32:29'),
(198, '2016-09-01 11:33:07'),
(199, '2016-09-01 11:34:55'),
(209, '2016-09-01 16:42:00'),
(210, '2016-09-01 16:43:25'),
(211, '2016-09-01 17:07:21'),
(212, '2016-09-01 17:08:42'),
(213, '2016-09-01 17:09:46'),
(214, '2016-09-02 17:14:26'),
(217, '2016-09-01 17:53:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `custofixo`
--

CREATE TABLE `custofixo` (
  `idconta` int(11) NOT NULL,
  `consumo` double NOT NULL,
  `tipocustofixo_idtipocustofixo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `custofixo`
--

INSERT INTO `custofixo` (`idconta`, `consumo`, `tipocustofixo_idtipocustofixo`) VALUES
(111, 4, 1),
(116, 4, 2),
(117, 6, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `destaques`
--

CREATE TABLE `destaques` (
  `idDestaques` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `dataEntrada` datetime NOT NULL,
  `dataSaida` datetime NOT NULL,
  `link` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formapagamento`
--

CREATE TABLE `formapagamento` (
  `idTipoPagamento` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `formapagamento`
--

INSERT INTO `formapagamento` (`idTipoPagamento`, `titulo`, `descricao`) VALUES
(1, 'Dinheiro', ''),
(2, 'Cartão', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicosituacao`
--

CREATE TABLE `historicosituacao` (
  `idPedido` int(11) NOT NULL,
  `idSituacaoPedido` int(11) NOT NULL,
  `dataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `insumo`
--

CREATE TABLE `insumo` (
  `idprodutoVenda` int(11) NOT NULL,
  `idprodutoInsumo` int(11) NOT NULL,
  `quantidade` float NOT NULL,
  `unidade` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `insumo`
--

INSERT INTO `insumo` (`idprodutoVenda`, `idprodutoInsumo`, `quantidade`, `unidade`) VALUES
(8, 7, 0.5, 'kg'),
(8, 9, 2, 'unidade'),
(8, 12, 1, 'unidade'),
(10, 9, 1, 'unidade'),
(10, 12, 0.3, 'kg'),
(11, 9, 1, 'unidade'),
(11, 12, 0.8, 'kg'),
(14, 9, 1, 'unidade'),
(14, 12, 0.4, 'kg'),
(19, 7, 0.4, 'kg'),
(19, 9, 1, 'unidade'),
(37, 9, 1, 'unidade'),
(37, 13, 1, 'unidade'),
(38, 7, 0.2, 'kg'),
(38, 9, 1, 'unidade'),
(38, 12, 0.6, 'kg'),
(44, 9, 2, 'unidade'),
(44, 12, 1.5, 'kg'),
(47, 9, 1, 'unidade'),
(47, 45, 0.3, 'kg'),
(47, 46, 0.2, 'kg'),
(59, 7, 0.1, 'kg'),
(59, 9, 1, 'unidade'),
(59, 12, 0.3, 'kg'),
(60, 9, 1, 'unidade'),
(62, 9, 1, 'unidade'),
(62, 12, 0.5, 'kg'),
(63, 9, 1, 'unidade'),
(63, 12, 0.9, 'kg'),
(65, 9, 1, 'unidade'),
(65, 64, 1, 'unidade'),
(67, 9, 1, 'unidade'),
(67, 12, 1, 'unidade'),
(67, 66, 1, 'unidade');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itemcardapio`
--

CREATE TABLE `itemcardapio` (
  `idCardapio` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ordem` int(11) DEFAULT NULL COMMENT 'ordem exibicao'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itempedido`
--

CREATE TABLE `itempedido` (
  `idPedido` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `total` float NOT NULL COMMENT 'Preço do produto venda * quantidade'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `itempedido`
--

INSERT INTO `itempedido` (`idPedido`, `idProduto`, `quantidade`, `total`) VALUES
(1, 8, 1, 3),
(2, 8, 1, 3),
(7, 14, 1, 2),
(11, 8, 1, 3),
(12, 11, 1, 1),
(12, 14, 1, 2),
(12, 47, 1, 3),
(13, 10, 1, 2),
(14, 10, 3, 6),
(14, 65, 3, 7),
(15, 14, 1, 2),
(16, 65, 1, 2),
(17, 14, 1, 2),
(18, 59, 1, 5),
(21, 8, 1, 3),
(22, 8, 1, 3),
(23, 11, 1, 1),
(24, 11, 1, 0.918),
(25, 11, 1, 0.92),
(26, 10, 1, 2),
(27, 11, 1, 0.92),
(28, 8, 1, 2.83),
(29, 8, 1, 2.83),
(30, 8, 1, 2.83),
(31, 8, 1, 2.83),
(32, 10, 2, 4),
(32, 65, 2, 4.38),
(33, 8, 1, 2.83),
(34, 67, 1, 2.66);

--
-- Acionadores `itempedido`
--
DELIMITER $$
CREATE TRIGGER `trg_atualizaTotalPedidoDelete` AFTER DELETE ON `itempedido` FOR EACH ROW BEGIN

CALL atualizaTotalPedidoDelete(old.idPedido,old.total);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_atualizaTotalPedidoInsert` AFTER INSERT ON `itempedido` FOR EACH ROW BEGIN
call atualizaTotalPedidoInsert(NEW.idPedido,NEW.total);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_atualizaTotalPedidoUpdate` AFTER UPDATE ON `itempedido` FOR EACH ROW BEGIN
call atualizaTotalPedidoUpdate(NEW.idPedido,NEW.total,OLD.total);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja`
--

CREATE TABLE `loja` (
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

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `disponivel` tinyint(4) NOT NULL COMMENT 'Status da mesa como ocupado/livre',
  `alerta` tinyint(4) NOT NULL COMMENT 'Campo para geração do alerta\n, caso ele esteja ativado  gerará \numa idenficação visual para\n',
  `qrcode` varchar(100) NOT NULL COMMENT 'localização ',
  `chave` varchar(45) NOT NULL COMMENT 'chave da mesa, criada no momento da criação da mesma',
  `cont` int(11) NOT NULL DEFAULT '0' COMMENT 'valor de iniciação do algoritimo de chaves\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `mesa`
--

INSERT INTO `mesa` (`idMesa`, `descricao`, `disponivel`, `alerta`, `qrcode`, `chave`, `cont`) VALUES
(1, '-', 1, 0, '-', '-', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE `migration` (
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

CREATE TABLE `pagamento` (
  `idConta` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `formapagamento_idTipoPagamento` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamento`
--

INSERT INTO `pagamento` (`idConta`, `idPedido`, `formapagamento_idTipoPagamento`) VALUES
(171, 158, 0),
(179, 0, 0),
(180, 0, 0),
(181, 1, 0),
(187, 7, 0),
(191, 11, 0),
(199, 18, 0),
(202, 21, 0),
(203, 22, 0),
(204, 23, 0),
(205, 24, 0),
(206, 25, 0),
(207, 26, 0),
(208, 27, 0),
(212, 31, 0),
(170, 157, 1),
(182, 2, 1),
(192, 12, 1),
(193, 13, 1),
(195, 14, 1),
(196, 15, 1),
(197, 16, 1),
(198, 17, 1),
(209, 28, 1),
(210, 29, 1),
(214, 33, 1),
(217, 34, 1),
(172, 159, 2),
(211, 30, 2),
(213, 32, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `totalPedido` float NOT NULL,
  `idSituacaoAtual` int(11) NOT NULL COMMENT 'Situação atual do staus do pedido, \nfacilitar na busca do status do pedido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`idPedido`, `totalPedido`, `idSituacaoAtual`) VALUES
(1, 3, 1),
(2, 3, 2),
(7, 2, 1),
(11, 3, 1),
(12, 6, 2),
(13, 2, 2),
(14, 13, 2),
(15, 2, 2),
(16, 2, 2),
(17, 2, 2),
(18, 5, 1),
(28, 2.83, 2),
(29, 2.83, 2),
(30, 2.83, 2),
(31, 2.83, 1),
(32, 8.38, 2),
(33, 2.83, 2),
(34, 2.66, 2);

--
-- Acionadores `pedido`
--
DELIMITER $$
CREATE TRIGGER `trg_atualizaContaPedido` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
call atualizaTotalContaUpdate(new.idPedido);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_deletePedidoConta` AFTER DELETE ON `pedido` FOR EACH ROW BEGIN
call deletePedidoConta(OLD.idPedido);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insereContaPedido` AFTER INSERT ON `pedido` FOR EACH ROW BEGIN
CALL insereContaPedido(new.idPedido);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `valorVenda` float DEFAULT NULL,
  `isInsumo` tinyint(1) NOT NULL,
  `quantidadeMinima` float NOT NULL DEFAULT '0',
  `idCategoria` int(11) NOT NULL,
  `quantidadeEstoque` float DEFAULT '0' COMMENT 'Valor deve ser maior que 0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `nome`, `valorVenda`, `isInsumo`, `quantidadeMinima`, `idCategoria`, `quantidadeEstoque`) VALUES
(7, 'Tomate', 20, 1, 35, 4, 31.5),
(8, 'Sanduíche A', 2.8325, 0, 0, 5, 0),
(9, 'Pão', 0, 1, 0, 3, 76),
(10, 'Refrigerante', 2, 0, 0, 5, 10),
(11, 'Sanduíche B', 0.918, 0, 0, 5, 0),
(12, 'Hambúrguer ', 0, 1, 0, 3, 59.5),
(13, 'Ovo', 0, 1, 0, 3, 65),
(14, 'Sanduíche C', 2, 0, 0, 5, 0),
(18, 'Insumo Teste', 0, 1, 2, 4, 3),
(19, 'Sanduiche X-Bacon', 1, 0, 0, 5, 0),
(37, 'Sanduiche X-Egg', 3, 0, 0, 5, 0),
(38, 'Sanduiche X-Tudo', 5, 0, 0, 5, 0),
(44, 'Sanduiche X-Duplo', 1, 0, 0, 5, 0),
(45, 'Queijo', 0, 1, 0, 3, 19.7),
(46, 'Presunto', 0, 1, 0, 3, 19.8),
(47, 'Sanduiche X-Misto', 3, 0, 0, 5, 0),
(50, 'Alface', 0, 1, 2, 4, 3),
(59, 'Sanduiche X-Especial', 5.43, 0, 0, 5, 0),
(60, 'Misto-Quente', 5.45, 0, 0, 5, 0),
(61, 'Salsicha', NULL, 1, 0, 4, 2),
(62, 'X-Casa', 5.25, 0, 0, 5, 0),
(63, 'Hambúrguer ', 6.54, 0, 0, 5, 0),
(64, 'Batata', NULL, 1, 0, 4, 11),
(65, 'X-Batata', 2.19, 0, 0, 5, 0),
(66, 'Cebola', NULL, 1, 0, 4, 19),
(67, 'X-Cebola', 1.6605, 0, 0, 5, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `created_at`, `updated_at`, `full_name`) VALUES
(1, 1, '2016-01-26 02:42:07', '2016-01-28 01:27:25', 'Admin'),
(2, 2, '2016-01-26 20:58:10', '2016-01-28 01:17:46', ''),
(3, 3, '2016-01-26 21:02:42', '2016-01-31 04:37:09', ''),
(33, 43, '2016-02-01 01:00:46', '2016-08-16 03:30:39', ''),
(34, 44, '2016-02-01 01:01:26', '2016-02-01 01:01:26', NULL),
(59, 80, '2016-02-05 03:30:47', '2016-02-05 05:19:16', ''),
(63, 84, '2016-02-09 02:14:53', '2016-08-16 03:31:05', ''),
(64, 85, '2016-02-10 06:13:27', '2016-08-16 03:33:26', ''),
(65, 104, '2016-02-14 05:09:25', '2016-02-14 06:02:05', ''),
(69, 108, '2016-02-14 06:30:37', '2016-08-16 03:30:13', ''),
(70, 109, '2016-02-14 22:38:19', '2016-08-16 03:39:32', ''),
(76, 115, '2016-08-15 02:02:35', '2016-08-16 03:34:11', ''),
(77, 116, '2016-09-02 00:01:41', '2016-09-02 00:01:41', 'teste8');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio`
--

CREATE TABLE `relatorio` (
  `idrelatorio` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `datageracao` date NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `inicio_intervalo` date DEFAULT NULL,
  `fim_intervalo` date NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `relatorio`
--

INSERT INTO `relatorio` (`idrelatorio`, `nome`, `datageracao`, `tipo`, `inicio_intervalo`, `fim_intervalo`, `usuario_id`) VALUES
(13, '', '2016-06-26', 'Contasareceber', '2016-05-08', '2016-05-31', 84),
(14, '', '2016-07-14', 'Contasareceber', '2016-05-08', '2016-06-03', 84),
(15, '', '2016-06-26', 'Contasareceber', '2016-05-29', '2016-07-01', 84),
(16, '', '2016-07-23', 'Contasareceber', '2016-01-01', '2016-12-31', 84),
(17, '', '2016-07-17', 'Pagamento', '2016-06-01', '2016-08-07', 84),
(20, '', '2016-07-14', 'Pedido', '2016-01-01', '2016-09-08', 84),
(21, '', '2016-07-17', 'Pedido', '2016-06-01', '2016-08-01', 84),
(22, '', '2016-07-17', 'Itempedido', '2016-05-01', '2016-05-31', 84),
(26, '', '2016-07-17', 'Itempedido', '2009-12-28', '2016-12-30', 84),
(27, '', '2016-07-21', 'Contasareceber', '2010-07-01', '2016-12-31', 84),
(28, '', '2016-07-23', 'Lucro', '2016-01-01', '2016-12-31', 84),
(29, '', '2016-07-24', 'Contasareceber', '2016-07-24', '2016-07-31', 84),
(30, '', '2016-08-06', 'Lucro', '2016-07-24', '2016-08-07', 84),
(31, '', '2016-08-06', 'Itempedido', '2016-07-24', '2016-08-07', 84),
(32, '', '2016-08-06', 'Pedido', '2016-07-24', '2016-08-06', 84),
(33, '', '2016-08-13', 'Pagamento', '2016-07-31', '2016-09-10', 84),
(34, '', '2016-09-01', 'Lucro', '2016-08-28', '2016-10-07', 84),
(35, '', '2016-09-01', 'Itempedido', '2016-08-28', '2016-10-07', 84);

-- --------------------------------------------------------

--
-- Estrutura da tabela `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `situacaopedido` (
  `idSituacaoPedido` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` text NOT NULL COMMENT 'ESTARA INCLUSO NA TABELA DE SISTEMA\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `situacaopedido`
--

INSERT INTO `situacaopedido` (`idSituacaoPedido`, `titulo`, `descricao`) VALUES
(1, 'Em andamento', '-'),
(2, 'Concluído', ''),
(3, 'Cancelado', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocustofixo`
--

CREATE TABLE `tipocustofixo` (
  `idtipocustofixo` int(11) NOT NULL,
  `tipocustofixo` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipocustofixo`
--

INSERT INTO `tipocustofixo` (`idtipocustofixo`, `tipocustofixo`) VALUES
(1, 'Água'),
(2, 'Energia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `username`, `password`, `auth_key`, `access_token`, `logged_in_ip`, `logged_in_at`, `created_ip`, `created_at`, `updated_at`, `banned_at`, `banned_reason`) VALUES
(1, 1, 1, 'admin@sigir.com', 'admin', '$2y$13$ZaQ4eZwz1ZevK9oaKksT2uKcUlh1aytLRyqGGUGYJSzNLuBcYJOvO', '4c1Lk1bFV-2gSyrQnXm7661avqoQOC0L', 'W6ELUzLx6Zvva8fQ5NV4nLl8jJInF_BC', '127.0.0.1', '2016-06-13 06:34:01', NULL, '2016-01-26 02:42:06', '2016-01-28 01:27:25', NULL, NULL),
(2, 2, 1, 'gerente@sigir.com', 'gerente2', '$2y$13$SVYrr6CicYYdpMnep5LKtO8ak84X8h6tFHYVpR8j7nGupVOvqnpVa', 'VPd_SzxMvyTgZprvDA-tfT4kPW_IYzZD', 'UyNFyd41oMBIiRVurZPZuvt6kgTe98xy', '::1', '2016-02-07 23:58:31', '::1', '2016-01-26 20:58:10', '2016-01-31 01:28:29', NULL, NULL),
(3, 3, 1, 'funcionario@sigir.com', 'funcionario', '$2y$13$.gl9ePCdOVOww1C7AZosD.GSsbD6cMERou36tWYrmEN.dtEFkml9i', 't6g9cyhdz2-EKqG3Whb6TC30qNPQ6oU7', 'BAWIuKS9sXShdh2fM3QnwH8ZqdT5mGwv', '::1', '2016-02-02 05:21:59', '::1', '2016-01-26 21:02:42', '2016-01-31 04:37:09', NULL, NULL),
(43, 3, 1, 'funcionario1@sigir.com', 'funcionario01', '$2y$13$MR/pQJFMZRJZkZj4.xg0qOtdjJK6NMaMo5jF4bVt1tPHf7sjr0QHi', 'JoIVj9p9IWlVklx1TZ00otnbcr-Gmao7', 'hAYvnkL8pFzP6FGMH7eKw7UmisflzyjX', '::1', '2016-02-05 03:48:25', '::1', '2016-02-01 01:00:46', '2016-08-16 03:30:38', NULL, NULL),
(44, 2, 1, 'gerente1@sigir.com', 'gerente', '$2y$13$mujgA7j0OsPxUr0gYAao3OSk1yykiEFfxqXis7m.lzvZ3EWID1jOG', 'c4rPsYI-Q-WNI9GgYyTvbZr_ynwyuAlY', 'nAzvxmIB3bTRTW9d23dn1isBFBr6s7RI', '::1', '2016-02-09 23:37:54', '::1', '2016-02-01 01:01:26', '2016-02-09 07:11:09', NULL, NULL),
(80, 2, 1, 'teste@teste.com', NULL, '$2y$13$Up2wVYVIsBKk3oij/H/8l.5hPym80.3NTFpGlc97cSJg32EqNGn4y', 'EXAFyYZpG5QVTcGx6yeFrlDOl9OizMuM', 'ZdjGbu9FKlXtF5mYt1A4CcShpkEaTd9i', '::1', '2016-02-08 01:22:20', '::1', '2016-02-05 03:30:47', '2016-02-05 05:19:16', NULL, NULL),
(84, 2, 1, 'user@master.com', NULL, '$2y$13$hiUnt5bM5nC02ntGxCCmBesZZIFNs5p/pfQ2ZNtNTvUdFcDGr5ZCa', 'RdSnQjSZqz7Z2_bQUTFgmbJAhug45hFL', '38W0FnvUuYydns3nmlBagAIpH2R3NQuY', '::1', '2016-09-01 22:36:07', '::1', '2016-02-09 02:14:53', '2016-08-16 03:31:05', NULL, NULL),
(85, 2, 1, 'compras@compras.com', 'Compra', '$2y$13$fcSVvuFUmhH.3iZ0wTtoZOpkVTt1tjAg2fO2thZog9QwMUIEUUzKu', 'tVH-bh0RpqSA1RgMqIR4rqcKtKiGhvPB', '165xJKTAkwnR1QcUd6wQ-fkU8Q98od2O', '::1', '2016-02-12 04:37:12', '::1', '2016-02-10 06:13:27', '2016-08-16 03:33:26', NULL, NULL),
(104, 2, 1, 'teste3@teste.com', 'teste3', '$2y$13$4MrmhHyYwYzQ5uFHtr8rpeUNCgFCZiHR0410sdcJBABbm/zl/1Z..', 'ndzPwraET0uG3RZMtH23_-7IdxZtiRaH', 'nO74vFAzRakvIVNVrrJLrl4CU9718fzh', '::1', '2016-02-14 05:59:05', '::1', '2016-02-14 05:09:25', '2016-02-14 06:02:05', NULL, NULL),
(108, 2, 1, 'teste4@teste.com', 'teste44', '$2y$13$COZu07CnXAVlfSQJwK6ng.LnOd43dGyN29Tw/FH13Mtoa/zTtlGwy', 'Hs7QEYX6yxldLcpIVPjwNoBNBY5zWDSa', 'Ib_71XRL0h05Yr1STAjJwv9Y3sfJOIW4', '::1', '2016-02-14 06:35:23', '::1', '2016-02-14 06:30:37', '2016-08-16 03:30:13', NULL, NULL),
(109, 2, 1, 'teste5@teste.com', 'te5te', '$2y$13$kmvcINGlBELnlIkODn5jROZn1j9YaK6gUOgE1d1hLgVRK0Div9ZDC', 'qhwHHhEN3dUbQlbS-KgD0s-FeCaEHWN8', 'bjaxj0OwAYpBgPGkY-8IiQz6078n-lHd', '::1', '2016-08-16 03:40:01', '::1', '2016-02-14 22:38:19', '2016-08-16 03:39:32', NULL, NULL),
(115, 2, 1, 'teste6@email.com', NULL, '$2y$13$cFGqNPixglFo4MA1ESwYWerm8Z3px6uAqvtSdtSacUnDiSdRfX1jG', '9uNwyOQ7xuFqkjr6x5dxdKUd7e_F0PnQ', 'nqD8TJOSYAShSm_WM3bbvpa2-42YzQi6', '::1', '2016-08-16 03:43:27', '::1', '2016-08-15 02:02:34', '2016-08-16 03:34:11', NULL, NULL),
(116, 2, 1, 'teste8@email.com', 'teste8', '$2y$13$Tld/quLHn850ewaKjcc9wuREdlEPGW4xI2MzZ/R3n9qRdMWBnlZs2', 'd3zpSG2zdeKGwqQdYPLUCr4INnb-7FHL', 'oj--ygpeu18CD1QpTd4xnpTKtq3hfelh', NULL, NULL, '::1', '2016-09-02 00:01:41', '2016-09-02 00:01:41', NULL, NULL);

--
-- Acionadores `user`
--
DELIMITER $$
CREATE TRIGGER `add_permissao_trigger_insert` AFTER INSERT ON `user` FOR EACH ROW BEGIN

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_auth`
--

CREATE TABLE `user_auth` (
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

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `usuario` (
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
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `auth_item_child_ibfk_2` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`idcaixa`),
  ADD KEY `caixa_ibfk_1` (`user_id`);

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
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idconta`);

--
-- Indexes for table `compraproduto`
--
ALTER TABLE `compraproduto`
  ADD PRIMARY KEY (`idCompra`,`idProduto`),
  ADD KEY `compraproduto_ibfk_2` (`idProduto`);

--
-- Indexes for table `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`idconta`);

--
-- Indexes for table `contasapagar`
--
ALTER TABLE `contasapagar`
  ADD PRIMARY KEY (`idconta`);

--
-- Indexes for table `contasareceber`
--
ALTER TABLE `contasareceber`
  ADD PRIMARY KEY (`idconta`);

--
-- Indexes for table `custofixo`
--
ALTER TABLE `custofixo`
  ADD PRIMARY KEY (`idconta`),
  ADD KEY `fk_custofixo_contasapagar1_idx` (`idconta`),
  ADD KEY `fk_custofixo_tipocustofixo1_idx` (`tipocustofixo_idtipocustofixo`);

--
-- Indexes for table `destaques`
--
ALTER TABLE `destaques`
  ADD PRIMARY KEY (`idDestaques`);

--
-- Indexes for table `formapagamento`
--
ALTER TABLE `formapagamento`
  ADD PRIMARY KEY (`idTipoPagamento`);

--
-- Indexes for table `historicosituacao`
--
ALTER TABLE `historicosituacao`
  ADD PRIMARY KEY (`idPedido`,`idSituacaoPedido`),
  ADD KEY `fk_historioSituacao_situacaoPedido1_idx` (`idSituacaoPedido`);

--
-- Indexes for table `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`idprodutoVenda`,`idprodutoInsumo`),
  ADD KEY `idprodutoInsumo` (`idprodutoInsumo`);

--
-- Indexes for table `itemcardapio`
--
ALTER TABLE `itemcardapio`
  ADD PRIMARY KEY (`idCardapio`,`idProduto`),
  ADD KEY `fk_itemcardapio_produto1_idx` (`idProduto`);

--
-- Indexes for table `itempedido`
--
ALTER TABLE `itempedido`
  ADD PRIMARY KEY (`idPedido`,`idProduto`),
  ADD KEY `fk_itemPedido_produto1_idx` (`idProduto`);

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
  ADD PRIMARY KEY (`idConta`,`idPedido`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `fk_pagamento_formapagamento1_idx` (`formapagamento_idTipoPagamento`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_pedido_situacaoPedido1_idx` (`idSituacaoAtual`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `fk_produto_categoria1_idx` (`idCategoria`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_user_id` (`user_id`);

--
-- Indexes for table `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`idrelatorio`),
  ADD KEY `fk_relatorio_usuario1` (`usuario_id`);

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
-- Indexes for table `tipocustofixo`
--
ALTER TABLE `tipocustofixo`
  ADD PRIMARY KEY (`idtipocustofixo`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`),
  ADD UNIQUE KEY `user_username` (`username`),
  ADD KEY `user_role_id` (`role_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_auth_provider_id` (`provider_id`),
  ADD KEY `user_auth_user_id` (`user_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_token_token` (`token`),
  ADD KEY `user_token_user_id` (`user_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD KEY `fk_usuario_loja1` (`loja_nome`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caixa`
--
ALTER TABLE `caixa`
  MODIFY `idcaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `idCardapio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `conta`
--
ALTER TABLE `conta`
  MODIFY `idconta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;
--
-- AUTO_INCREMENT for table `formapagamento`
--
ALTER TABLE `formapagamento`
  MODIFY `idTipoPagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `idrelatorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `situacaopedido`
--
ALTER TABLE `situacaopedido`
  MODIFY `idSituacaoPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipocustofixo`
--
ALTER TABLE `tipocustofixo`
  MODIFY `idtipocustofixo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
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
-- Limitadores para a tabela `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD CONSTRAINT `auth_rule_ibfk_1` FOREIGN KEY (`name`) REFERENCES `auth_item` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `compraproduto`
--
ALTER TABLE `compraproduto`
  ADD CONSTRAINT `compraproduto_ibfk_2` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `contasapagar`
--
ALTER TABLE `contasapagar`
  ADD CONSTRAINT `contasapagar_ibfk_1` FOREIGN KEY (`idconta`) REFERENCES `conta` (`idconta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `contasareceber`
--
ALTER TABLE `contasareceber`
  ADD CONSTRAINT `contasareceber_ibfk_1` FOREIGN KEY (`idconta`) REFERENCES `conta` (`idconta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `custofixo`
--
ALTER TABLE `custofixo`
  ADD CONSTRAINT `fk_custofixo_contasapagar1` FOREIGN KEY (`idconta`) REFERENCES `contasapagar` (`idconta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_custofixo_tipocustofixo1` FOREIGN KEY (`tipocustofixo_idtipocustofixo`) REFERENCES `tipocustofixo` (`idtipocustofixo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `historicosituacao`
--
ALTER TABLE `historicosituacao`
  ADD CONSTRAINT `fk_historioSituacao_situacaoPedido10` FOREIGN KEY (`idSituacaoPedido`) REFERENCES `situacaopedido` (`idSituacaoPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `historicosituacao_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `insumo`
--
ALTER TABLE `insumo`
  ADD CONSTRAINT `insumo_ibfk_1` FOREIGN KEY (`idprodutoVenda`) REFERENCES `produto` (`idProduto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insumo_ibfk_2` FOREIGN KEY (`idprodutoInsumo`) REFERENCES `produto` (`idProduto`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_itemPedido_produto10` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `loja`
--
ALTER TABLE `loja`
  ADD CONSTRAINT `loja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produto_categoria10` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
