-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Jun-2016 às 06:45
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaTotalPedidoUpdate` (IN `iddoPedido` INT, IN `totalProduto` FLOAT, IN `oldTotalProduto` INT)  NO SQL
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
('caixa', 84, NULL),
('categoria', 84, NULL),
('compra', 84, NULL),
('compra', 85, NULL),
('conta', 84, NULL),
('contasapagar', 84, NULL),
('contasareceber', 84, NULL),
('create-compra', 85, NULL),
('create-fornecedor', 85, NULL),
('create-fornecedor', 104, NULL),
('create-fornecedor', 110, NULL),
('create-relatorio', 108, NULL),
('definirvalorprodutovenda', 84, NULL),
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
('insumo', 84, NULL),
('itempedido', 84, NULL),
('pedido', 84, NULL),
('produto', 84, NULL),
('produtosvenda', 84, NULL),
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
('avaliacaoproduto', 93, 'Avaliar Produto', NULL, NULL, NULL, NULL),
('caixa', 8, 'Caixa', NULL, NULL, NULL, NULL),
('cardapio', 38, 'Cardapio', NULL, NULL, NULL, NULL),
('categoria', 105, 'Categorias', NULL, NULL, NULL, NULL),
('compra', 26, 'Compra', NULL, NULL, NULL, NULL),
('conta', 117, 'Conta', NULL, NULL, NULL, NULL),
('contasapagar', 123, 'Conta a pagar', NULL, NULL, NULL, NULL),
('contasareceber', 129, 'Conta a receber', NULL, NULL, NULL, NULL),
('create-caixa', 11, 'Criar Caixa', NULL, NULL, NULL, NULL),
('create-cardapio', 42, 'Criar Cardapio', NULL, NULL, NULL, NULL),
('create-categoria', 107, 'Criar Categoria', NULL, NULL, NULL, NULL),
('create-compra', 29, 'Criar Compra', NULL, NULL, NULL, NULL),
('create-conta', 119, 'Criar Conta', NULL, NULL, NULL, NULL),
('create-contasapagar', 125, 'Criar Conta a pagar', NULL, NULL, NULL, NULL),
('create-contasareceber', 131, 'Criar Conta a receber', NULL, NULL, NULL, NULL),
('create-despesa', 5, 'Criar Despesa', NULL, NULL, NULL, NULL),
('create-destaque', 46, 'Criar Destaque', NULL, NULL, NULL, NULL),
('create-fornecedor', 17, 'Criar Fornecedor', NULL, NULL, NULL, NULL),
('create-historicosituacao', 52, 'Criar Histórico de Situação', NULL, NULL, NULL, NULL),
('create-insumo', 101, 'Criar Insumos', NULL, NULL, NULL, NULL),
('create-itemcardapio', 58, 'Criar Item-Cardapio', NULL, NULL, NULL, NULL),
('create-itempedido', 113, 'Criar Item Pedido', NULL, NULL, NULL, NULL),
('create-loja', 64, 'Criar Loja', NULL, NULL, NULL, NULL),
('create-mesa', 70, 'Criar Mesa', NULL, NULL, NULL, NULL),
('create-pagamento', 76, 'Criar Pagamento', NULL, NULL, NULL, NULL),
('create-pedido', 82, 'Criar Pedido', NULL, NULL, NULL, NULL),
('create-produto', 88, 'Criar Produto', NULL, NULL, NULL, NULL),
('create-relatorio', 23, 'Criar Relatório', NULL, NULL, NULL, NULL),
('create-user', 35, 'Criar Usuário', NULL, NULL, NULL, NULL),
('definirvalorprodutovenda', 98, 'Definir valor de venda de Produto Venda', NULL, NULL, NULL, NULL),
('delete-caixa', 13, 'Deletar Caixa', NULL, NULL, NULL, NULL),
('delete-cardapio', 41, 'Deletar Cardapio', NULL, NULL, NULL, NULL),
('delete-categoria', 110, 'Deletar Categoria', NULL, NULL, NULL, NULL),
('delete-compra', 31, 'Deletar Compra', NULL, NULL, NULL, NULL),
('delete-conta', 122, 'Deletar Conta', NULL, NULL, NULL, NULL),
('delete-contasapagar', 128, 'Deletar Conta a pagar', NULL, NULL, NULL, NULL),
('delete-contasareceber', 134, 'Deletar Conta a receber', NULL, NULL, NULL, NULL),
('delete-despesa', 7, 'Deletar Despesa', NULL, NULL, NULL, NULL),
('delete-destaque', 45, 'Deletar Destaque', NULL, NULL, NULL, NULL),
('delete-fornecedor', 19, 'Deletar Fornecedor', NULL, NULL, NULL, NULL),
('delete-historicosituacao', 51, 'Deletar Histórico Situação', NULL, NULL, NULL, NULL),
('delete-insumo', 104, 'Deletar Insumos', '', '', 0, NULL),
('delete-itemcardapio', 57, 'Delete Item-Cardapio', NULL, NULL, NULL, NULL),
('delete-itempedido', 116, 'Deletar Item Pedido', NULL, NULL, NULL, NULL),
('delete-loja', 63, 'Deletar Loja', NULL, NULL, NULL, NULL),
('delete-mesa', 69, 'Deletar Mesa', NULL, NULL, NULL, NULL),
('delete-pagamento', 75, 'Deletar Pagamento', NULL, NULL, NULL, NULL),
('delete-pedido', 81, 'Deletar Pedido', NULL, NULL, NULL, NULL),
('delete-produto', 87, 'Deletar Produto', NULL, NULL, NULL, NULL),
('delete-relatorio', 25, 'Deletar Relatório', NULL, NULL, NULL, NULL),
('delete-user', 37, 'Deletar Usuário', NULL, NULL, NULL, NULL),
('despesa', 2, 'Despesa', NULL, NULL, NULL, NULL),
('destaque', 44, 'Destaque', NULL, NULL, NULL, NULL),
('fornecedor', 14, 'Fornecedor', NULL, NULL, NULL, NULL),
('historicosituacao', 50, 'Historico Situação', NULL, NULL, NULL, NULL),
('index-caixa', 9, 'Listar Caixas', NULL, NULL, NULL, NULL),
('index-cardapio', 40, 'Listar Cardapio', NULL, NULL, NULL, NULL),
('index-categoria', 106, 'Listar Categorias', NULL, NULL, NULL, NULL),
('index-compra', 27, 'Listar Compras', NULL, NULL, NULL, NULL),
('index-conta', 118, 'Listar Contas', NULL, NULL, NULL, NULL),
('index-contasapagar', 124, 'Listar Contas a pagar', NULL, NULL, NULL, NULL),
('index-contasareceber', 130, 'Listar Contas a receber', NULL, NULL, NULL, NULL),
('index-despesa', 3, 'Listar Despesas', NULL, NULL, NULL, NULL),
('index-destaque', 47, 'Listar Destaques', NULL, NULL, NULL, NULL),
('index-fornecedor', 15, 'Listar Fornecedores', NULL, NULL, NULL, NULL),
('index-historicosituacao', 53, 'Listar Histórico de Situação', NULL, NULL, NULL, NULL),
('index-insumo', 100, 'Listar Insumos', NULL, NULL, NULL, NULL),
('index-itemcardapio', 59, 'Listar Item-Cardapio', NULL, NULL, NULL, NULL),
('index-itempedido', 112, 'Listar Item Pedido', NULL, NULL, NULL, NULL),
('index-loja', 65, 'Listar Lojas', NULL, NULL, NULL, NULL),
('index-mesa', 71, 'Listar Mesas', NULL, NULL, NULL, NULL),
('index-pagamento', 77, 'Listar Pagamentos', NULL, NULL, NULL, NULL),
('index-pedido', 83, 'Listar Pedidos', NULL, NULL, NULL, NULL),
('index-produto', 89, 'Listar Produtos', NULL, NULL, NULL, NULL),
('index-relatorio', 21, 'Listar Relatórios', NULL, NULL, NULL, NULL),
('index-user', 33, 'Listar Usuários', NULL, NULL, NULL, NULL),
('insumo', 99, 'Insumos', NULL, NULL, NULL, NULL),
('itemcardapio', 56, 'Item Cardapio', NULL, NULL, NULL, NULL),
('itempedido', 111, 'Item Pedido', NULL, NULL, NULL, NULL),
('listadeinsumos', 92, 'Listar Insumos', NULL, NULL, NULL, NULL),
('listadeprodutosporinsumo', 94, 'Listar Produtos de Venda por Insumo', NULL, NULL, NULL, NULL),
('loja', 62, 'Loja', NULL, NULL, NULL, NULL),
('mesa', 68, 'Mesa', NULL, NULL, NULL, NULL),
('pagamento', 74, 'Pagamento', NULL, NULL, NULL, NULL),
('pedido', 80, 'Pedido', NULL, NULL, NULL, NULL),
('produto', 86, 'Produto', NULL, NULL, NULL, NULL),
('produtosvenda', 95, 'Listar Produtos Venda', NULL, NULL, NULL, NULL),
('relatorio', 20, 'Relatório', NULL, NULL, NULL, NULL),
('update-caixa', 12, 'Editar Caixa', NULL, NULL, NULL, NULL),
('update-cardapio', 43, 'Atualizar Caradapio', NULL, NULL, NULL, NULL),
('update-categoria', 109, 'Atualizar Categoria', NULL, NULL, NULL, NULL),
('update-compra', 30, 'Editar Compra', NULL, NULL, NULL, NULL),
('update-conta', 121, 'Atualizar Conta', NULL, NULL, NULL, NULL),
('update-contasapagar', 127, 'Atualizar Conta a pagar', NULL, NULL, NULL, NULL),
('update-contasareceber', 133, 'Atualizar Conta a receber', NULL, NULL, NULL, NULL),
('update-despesa', 6, 'Editar Despesa', NULL, NULL, NULL, NULL),
('update-destaque', 48, 'Atualizar Destaque', NULL, NULL, NULL, NULL),
('update-fornecedor', 18, 'Editar Fornecedor', NULL, NULL, NULL, NULL),
('update-historicosituacao', 54, 'Atualizar Histórico de Situação', NULL, NULL, NULL, NULL),
('update-insumo', 103, 'Atualizar Insumos', NULL, NULL, NULL, NULL),
('update-itemcardapio', 60, 'Atualizar Item-Cardapio', NULL, NULL, NULL, NULL),
('update-itempedido', 115, 'Atualizar Item Pedido', NULL, NULL, NULL, NULL),
('update-loja', 66, 'Atualizar Loja', NULL, NULL, NULL, NULL),
('update-mesa', 72, 'Atualizar Mesa', NULL, NULL, NULL, NULL),
('update-pagamento', 78, 'Atualizar Pagamento', NULL, NULL, NULL, NULL),
('update-pedido', 85, 'Atualizar Pedido', NULL, NULL, NULL, NULL),
('update-produto', 90, 'Atualizar Produto', NULL, NULL, NULL, NULL),
('update-relatorio', 24, 'Editar Relatório', NULL, NULL, NULL, NULL),
('update-user', 36, 'Editar Usuário', NULL, NULL, NULL, NULL),
('user', 32, 'Usuário', NULL, NULL, NULL, NULL),
('view-caixa', 10, 'Visualizar Caixa', NULL, NULL, NULL, NULL),
('view-cardapio', 39, 'Visualizar Cardapio', NULL, NULL, NULL, NULL),
('view-categoria', 108, 'Visualizar Categoria', NULL, NULL, NULL, NULL),
('view-compra', 28, 'Visualizar Compra', NULL, NULL, NULL, NULL),
('view-conta', 120, 'Visualizar Conta', NULL, NULL, NULL, NULL),
('view-contasapagar', 126, 'Visualizar Conta a pagar', NULL, NULL, NULL, NULL),
('view-contasareceber', 132, 'Visualizar Conta a receber', NULL, NULL, NULL, NULL),
('view-despesa', 4, 'Visualizar Despesa', NULL, NULL, NULL, NULL),
('view-destaque', 49, 'Visualizar Destaque', NULL, NULL, NULL, NULL),
('view-fornecedor', 16, 'Visualizar Fornecedor', NULL, NULL, NULL, NULL),
('view-historicosituacao', 55, 'Listar Histórico de Situação', NULL, NULL, NULL, NULL),
('view-insumo', 102, 'Visualizar Insumos', NULL, NULL, NULL, NULL),
('view-itemcardapio', 61, 'Visualizar Item-Cardapio', NULL, NULL, NULL, NULL),
('view-itempedido', 114, 'Visualizar', NULL, NULL, NULL, NULL),
('view-loja', 67, 'Visualizar Loja', NULL, NULL, NULL, NULL),
('view-mesa', 73, 'Visualizar Mesa', NULL, NULL, NULL, NULL),
('view-pagamento', 79, 'Visualizar Pagamentos', NULL, NULL, NULL, NULL),
('view-pedido', 84, 'Visualizar Pedido', NULL, NULL, NULL, NULL),
('view-produto', 91, 'Visualizar Produto', NULL, NULL, NULL, NULL),
('view-relatorio', 22, 'Visualizar Relatório', NULL, NULL, NULL, NULL),
('view-user', 34, 'Visualizar Usuário', NULL, NULL, NULL, NULL);

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
  `valorapurado` float NOT NULL,
  `valoremcaixa` double NOT NULL,
  `valorlucro` float NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`idcaixa`, `valorapurado`, `valoremcaixa`, `valorlucro`, `user_id`) VALUES
(7, 0, 0, 0, 84);

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
(5, 'Lanche');

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

CREATE TABLE `compra` (
  `idconta` int(11) NOT NULL,
  `dataCompra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `compra`
--

INSERT INTO `compra` (`idconta`, `dataCompra`) VALUES
(79, '2016-06-02'),
(80, '2016-06-05');

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
(76, 7, 2, 5),
(76, 9, 1, 5),
(78, 7, 2, 5),
(78, 9, 1, 5),
(79, 9, 3, 5),
(80, 7, 3, 5),
(80, 9, 1, 5),
(80, 12, 10, 5),
(80, 13, 4, 5),
(80, 45, 5, 1),
(80, 46, 5, 1);

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
(2, 6, 'Luz', 'contasapagar', 0),
(3, 21, 'Pedido', 'contasareceber', 0),
(5, 1.23, 'Pedido', 'contasareceber', 0),
(6, 10.3100004196167, 'Água', 'contasapagar', 0),
(13, 5.67, 'receber', 'contasareceber', 0),
(14, 8.9, 'pagar', 'contasapagar', 0),
(42, 0, 'Pedido', 'contasareceber', 0),
(77, 0, 'Compra de 2016-06-02', 'contasapagar', 0),
(78, 0, 'Compra de 2016-06-03', 'contasapagar', 0),
(79, 0, 'Compra de 2016-06-02', 'contasapagar', 0),
(80, 0, 'Compra de 2016-06-05', 'contasapagar', 0),
(81, 0, 'Pedido', 'contasareceber', 0),
(82, 7, 'Pedido', 'contasareceber', 0),
(83, 5, 'Pedido', 'contasareceber', 0),
(84, 6, 'Pedido', 'contasareceber', 1);

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
(3, NULL),
(6, '2016-04-30'),
(14, '2016-05-18'),
(77, NULL),
(78, NULL),
(79, NULL),
(80, NULL);

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
(42, '2016-05-05 23:16:26'),
(81, '2016-05-23 00:56:50'),
(82, '2016-06-03 02:10:00'),
(83, '2016-05-23 01:16:22'),
(84, '2017-06-02 22:25:47');

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
(60, 9, 1, 'unidade');

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
  `quantidade` decimal(10,0) NOT NULL DEFAULT '1',
  `total` decimal(10,0) NOT NULL DEFAULT '0' COMMENT 'Preço do produto venda * quantidade'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `itempedido`
--

INSERT INTO `itempedido` (`idPedido`, `idProduto`, `quantidade`, `total`) VALUES
(2, 11, '2', '4'),
(3, 8, '2', '8'),
(3, 11, '3', '9'),
(10, 8, '4', '16'),
(105, 8, '1', '4'),
(107, 8, '2', '4'),
(107, 37, '1', '3'),
(108, 59, '1', '5'),
(109, 8, '1', '4'),
(109, 44, '2', '2');

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
  `idTipoPagamento` int(11) DEFAULT NULL,
  `idConta` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamento`
--

INSERT INTO `pagamento` (`idTipoPagamento`, `idConta`, `idPedido`) VALUES
(1, 42, 105),
(2, 43, 106),
(NULL, 82, 107),
(NULL, 83, 108),
(NULL, 84, 109);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `totalPedido` double NOT NULL DEFAULT '0',
  `idSituacaoAtual` int(11) NOT NULL COMMENT 'Situação atual do staus do pedido, \nfacilitar na busca do status do pedido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`idPedido`, `totalPedido`, `idSituacaoAtual`) VALUES
(2, 6, 1),
(3, 21, 1),
(5, 0, 1),
(8, 0, 1),
(10, 16, 2),
(105, 0, 2),
(106, 0, 1),
(107, 7, 1),
(108, 5, 1),
(109, 6, 1);

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
(7, 'Tomate', 20, 1, 0, 4, 61),
(8, 'Sanduíche A', 4.68, 0, 0, 5, 0),
(9, 'Pão', 0, 1, 0, 3, 36),
(10, 'Refrigerante', 2, 0, 0, 5, 10),
(11, 'Sanduíche B', 3, 0, 0, 5, 0),
(12, 'Hambúrguer ', 0, 1, 0, 3, 30.7),
(13, 'Ovo', 0, 1, 0, 3, 61),
(14, 'Sanduíche C', 2, 0, 0, 5, 0),
(18, 'Insumo Teste', 0, 1, 2, 4, 0),
(19, 'Sanduiche X-Bacon', 1, 0, 0, 5, 0),
(37, 'Sanduiche X-Egg', 3, 0, 0, 5, 0),
(38, 'Sanduiche X-Tudo', 5, 0, 0, 5, 0),
(44, 'Sanduiche X-Duplo', 1, 0, 0, 5, 0),
(45, 'Queijo', 0, 1, 0, 3, 15),
(46, 'Presunto', 0, 1, 0, 3, 15),
(47, 'Sanduiche X-Misto', 3, 0, 0, 5, 0),
(50, 'Alface', 0, 1, 2, 4, 0),
(59, 'Sanduiche X-Especial', 5.43, 0, 0, 5, 0),
(60, 'Misto-Quente', 5.45, 0, 0, 5, 0);

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
(5, 'Relatório 01', '2016-02-01', 'Compras', '2016-01-26', '2016-01-30', 44),
(6, 'Relatório 02', '2016-02-09', 'Faturamento', '2016-02-25', '2016-02-29', 84),
(7, 'testestesteste', '2016-02-14', NULL, NULL, '2016-02-15', 109);

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
(1, 1, 1, 'admin@sigir.com', 'admin', '$2y$13$ZaQ4eZwz1ZevK9oaKksT2uKcUlh1aytLRyqGGUGYJSzNLuBcYJOvO', '4c1Lk1bFV-2gSyrQnXm7661avqoQOC0L', 'W6ELUzLx6Zvva8fQ5NV4nLl8jJInF_BC', '127.0.0.1', '2016-06-06 07:42:24', NULL, '2016-01-26 02:42:06', '2016-01-28 01:27:25', NULL, NULL),
(2, 2, 1, 'gerente@sigir.com', 'gerente2', '$2y$13$SVYrr6CicYYdpMnep5LKtO8ak84X8h6tFHYVpR8j7nGupVOvqnpVa', 'VPd_SzxMvyTgZprvDA-tfT4kPW_IYzZD', 'UyNFyd41oMBIiRVurZPZuvt6kgTe98xy', '::1', '2016-02-07 23:58:31', '::1', '2016-01-26 20:58:10', '2016-01-31 01:28:29', NULL, NULL),
(3, 3, 1, 'funcionario@sigir.com', 'funcionario', '$2y$13$.gl9ePCdOVOww1C7AZosD.GSsbD6cMERou36tWYrmEN.dtEFkml9i', 't6g9cyhdz2-EKqG3Whb6TC30qNPQ6oU7', 'BAWIuKS9sXShdh2fM3QnwH8ZqdT5mGwv', '::1', '2016-02-02 05:21:59', '::1', '2016-01-26 21:02:42', '2016-01-31 04:37:09', NULL, NULL),
(43, 3, 1, 'funcionario1@sigir.com', 'funcionario01', '$2y$13$MR/pQJFMZRJZkZj4.xg0qOtdjJK6NMaMo5jF4bVt1tPHf7sjr0QHi', 'JoIVj9p9IWlVklx1TZ00otnbcr-Gmao7', 'hAYvnkL8pFzP6FGMH7eKw7UmisflzyjX', '::1', '2016-02-05 03:48:25', '::1', '2016-02-01 01:00:46', '2016-02-01 04:23:48', NULL, NULL),
(44, 2, 1, 'gerente1@sigir.com', 'gerente', '$2y$13$mujgA7j0OsPxUr0gYAao3OSk1yykiEFfxqXis7m.lzvZ3EWID1jOG', 'c4rPsYI-Q-WNI9GgYyTvbZr_ynwyuAlY', 'nAzvxmIB3bTRTW9d23dn1isBFBr6s7RI', '::1', '2016-02-09 23:37:54', '::1', '2016-02-01 01:01:26', '2016-02-09 07:11:09', NULL, NULL),
(80, 2, 1, 'teste@teste.com', NULL, '$2y$13$Up2wVYVIsBKk3oij/H/8l.5hPym80.3NTFpGlc97cSJg32EqNGn4y', 'EXAFyYZpG5QVTcGx6yeFrlDOl9OizMuM', 'ZdjGbu9FKlXtF5mYt1A4CcShpkEaTd9i', '::1', '2016-02-08 01:22:20', '::1', '2016-02-05 03:30:47', '2016-02-05 05:19:16', NULL, NULL),
(84, 2, 1, 'user@master.com', NULL, '$2y$13$hiUnt5bM5nC02ntGxCCmBesZZIFNs5p/pfQ2ZNtNTvUdFcDGr5ZCa', 'RdSnQjSZqz7Z2_bQUTFgmbJAhug45hFL', '38W0FnvUuYydns3nmlBagAIpH2R3NQuY', '::1', '2016-06-03 17:07:24', '::1', '2016-02-09 02:14:53', '2016-02-09 02:14:53', NULL, NULL),
(85, 2, 1, 'compras@compras.com', 'Compra', '$2y$13$fcSVvuFUmhH.3iZ0wTtoZOpkVTt1tjAg2fO2thZog9QwMUIEUUzKu', 'tVH-bh0RpqSA1RgMqIR4rqcKtKiGhvPB', '165xJKTAkwnR1QcUd6wQ-fkU8Q98od2O', '::1', '2016-02-12 04:37:12', '::1', '2016-02-10 06:13:27', '2016-02-13 17:20:37', NULL, NULL),
(104, 2, 1, 'teste3@teste.com', 'teste3', '$2y$13$4MrmhHyYwYzQ5uFHtr8rpeUNCgFCZiHR0410sdcJBABbm/zl/1Z..', 'ndzPwraET0uG3RZMtH23_-7IdxZtiRaH', 'nO74vFAzRakvIVNVrrJLrl4CU9718fzh', '::1', '2016-02-14 05:59:05', '::1', '2016-02-14 05:09:25', '2016-02-14 06:02:05', NULL, NULL),
(108, 2, 1, 'teste4@teste.com', 'teste44', '$2y$13$COZu07CnXAVlfSQJwK6ng.LnOd43dGyN29Tw/FH13Mtoa/zTtlGwy', 'Hs7QEYX6yxldLcpIVPjwNoBNBY5zWDSa', 'Ib_71XRL0h05Yr1STAjJwv9Y3sfJOIW4', '::1', '2016-02-14 06:35:23', '::1', '2016-02-14 06:30:37', '2016-02-14 06:35:48', NULL, NULL),
(109, 2, 1, 'teste5@teste.com', 'te5te', '$2y$13$kmvcINGlBELnlIkODn5jROZn1j9YaK6gUOgE1d1hLgVRK0Div9ZDC', 'qhwHHhEN3dUbQlbS-KgD0s-FeCaEHWN8', 'bjaxj0OwAYpBgPGkY-8IiQz6078n-lHd', '::1', '2016-03-02 04:25:06', '::1', '2016-02-14 22:38:19', '2016-03-02 04:26:23', NULL, NULL),
(110, 2, 1, 'teste6@teste.com', NULL, '$2y$13$HqbxlWNZCTEvklWOT0qe3.6SzPXRnw8Dw5NUvzwZbbRNUux6iRD0e', 'qu8OL_HN7TxFAYp8EQ1aUet-ApaO3ayK', '8ui-NK4VbPSmS6uTSBbLeiByU8ZSeOuj', '::1', '2016-03-02 04:33:26', '::1', '2016-03-02 04:30:57', '2016-03-02 04:49:11', NULL, NULL);

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
  ADD KEY `idPedido` (`idPedido`);

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
  MODIFY `idcaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `idCardapio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `conta`
--
ALTER TABLE `conta`
  MODIFY `idconta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
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
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `idrelatorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
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
-- Limitadores para a tabela `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idconta`) REFERENCES `conta` (`idconta`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_itemPedido_produto10` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `itempedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `loja`
--
ALTER TABLE `loja`
  ADD CONSTRAINT `loja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idSituacaoAtual`) REFERENCES `situacaopedido` (`idSituacaoPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

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
