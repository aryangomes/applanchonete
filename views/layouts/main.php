<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use app\models\Loja;

use app\models\Caixa;
use yii\helpers\Url;
use app\models\Produto;

AppAsset::register($this);

$formatter = \Yii::$app->formatter;

$caixa = new Caixa();

//Pega a instaância do caixa aberto
$caixa = $caixa->getCaixaAberto(Yii::$app->user->getId());

//Rechpera o nome da loja
$loja = Loja::find()->where(['user_id' => Yii::$app->user->getId()])->one();

//Busca os produtos com estoque mínimo
$qtdProdutoMinimo = Produto::find()->where("quantidadeMinima >= quantidadeEstoque AND isInsumo = 1")->all();

//Verifica se o nome da Loja está cadastrado
if (count($loja) > 0) {

    $nomeLoja = $loja->nome;
    $url = Url::toRoute(['/loja/view', 'id' => Yii::$app->user->getId()]);
} else {
    $nomeLoja = 'Cadastre sua loja';
    $url = Url::toRoute(['/loja/create']);
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="<?= \Yii::getAlias('@web') . '/sgl.ico' ?>" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Sistema de Gerência de Lanchonete' /* $this->title */) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>
<?php if (!\Yii::$app->user->isGuest) {
?>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= Html::a('Sistema de Gerência de Lanchonete', ['/'], ['class' => 'navbar-brand']) ?>
        </div>

        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">

            <!--      Dropdown Acesso Rápido      -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-align-justify"></i>
                    Acesso Rápido<b class="caret"></b></a>
                <ul class="dropdown-menu">

                    <?php
                    if (Yii::$app->user->can("create-pedido") || Yii::$app->user->can("pedido")) {
                        ?>
                        <li>
                            <?= Html::a('<i class="fa fa-external-link-square"></i> Cadastrar Pedido', ['/pedido/create']) ?>

                        </li>
                        <?php
                    }
                    ?>

                    <li class="divider"></li>
                    <?php
                    if (Yii::$app->user->can("create-produto") || Yii::$app->user->can("produto")) {
                        ?>
                        <li>
                            <?= Html::a('<i class="fa fa-external-link-square"></i> Cadastrar Produto', ['/produto/create']) ?>

                        </li>
                        <?php
                    }
                    ?>
                    <li class="divider"></li>
                    <?php
                    if (Yii::$app->user->can("create-conta") || Yii::$app->user->can("conta")) {
                        ?>
                        <li>
                            <?= Html::a('<i class="fa fa-external-link-square"></i> Cadastrar Conta', ['/conta/create']) ?>

                        </li>
                        <?php
                    }
                    ?>

                    <li class="divider"></li>
                    <?php
                    if (Yii::$app->user->can("index-cardapio") || Yii::$app->user->can("cardapio")) {
                        ?>
                        <li>
                            <?= Html::a('<i class="fa fa-external-link-square"></i> Lista de Cardápios', ['/cardapio/index']) ?>

                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </li>
            <!--      Dropdown Acesso Rápido      -->



            <!--      Dropdown Notificações      -->
            <?php
            if (Yii::$app->user->can("caixa") || Yii::$app->user->can("despesa")) {
            ?>
            <li class="dropdown">


            </li>
            <li class="dropdown">
                    <?php
                    if (Yii::$app->user->can("caixa")) {
                    ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <?php
                if (isset($caixa) && $caixa->valoremcaixa < 1 || count($qtdProdutoMinimo) > 0) {
                ?>
                <i class="fa fa-bell"></i>
                <span class="label label-danger">
                                                    !
                                                </span>
                <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <?php
                        if (isset($caixa) && $caixa->valoremcaixa < 1) {
                            ?>
                            <li><a href="<?= Url::toRoute('/caixa') ?>"> Há um déficit no caixa </a>
                            </li>
                            <li class="divider"></li>
                            <?php
                        }


                        if (count($qtdProdutoMinimo) > 0) {
                            echo "<li><a><b>Produtos com quantidade em estoque com valor mínimo</b></a></li>";
                            foreach ($qtdProdutoMinimo as $p) {
                                ?>
                                <li>
                                    <a href="<?= Url::toRoute(['/produto/view', 'id' => $p->idProduto]) ?>"> <?= $p->nome ?> </a>
                                </li>
                                <li class="divider"></li>
                                <?php
                            }
                        }
                        }
                        else
                                    {
                                    ?>
                                    <i class="fa fa-bell"></i>

                                    <b class="caret"></b></a>
                                    <ul class="dropdown-menu alert-dropdown">
                                        <li>
                                            &nbsp; Não há alertas
                                        </li>
                                        <?php
                                        }
                            }
                        }
                        ?>


                    </ul>
                    </li>
                        <!--      Dropdown Notificações      -->

                        <!--      Dropdown Usuário      -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                                <?= Yii::$app->user->displayName ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= Url::toRoute('/user/account') ?>"><i class="fa fa-fw fa-user"></i> Perfil</a>
                                </li>

                                <li class="divider"></li>
                                <li>
                                    <a href="<?= Url::toRoute('/user/logout') ?>" data-method='POST'><i
                                            class="fa fa-fw fa-power-off"></i> Sair</a>
                                </li>
                            </ul>
                        </li>
                        <!--      Dropdown Usuário      -->
                </ul>


                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

                <div class="collapse navbar-collapse navbar-ex1-collapse ">
                    <ul class="nav navbar-nav side-nav">
                        <li>
                            <?= Html::a('<i class="fa fa-fw fa-home"></i> Home', ['/site/index']) ?>

                        </li>

                        <?php
                        if (Yii::$app->user->can("index-caixa") || Yii::$app->user->can("caixa")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-money"></i> Caixa', ['/caixa/index']) ?>

                            </li>

                            <?php
                        }
                        ?>
                        <!--     <li>
                            <?php // Html::a('<i class="fa fa-fw fa-table"></i> Loja', ['loja/index']) ?>
                        </li> -->

                        <?php
                        if (Yii::$app->user->can("index-fornecedor") || Yii::$app->user->can("fornecedor")) {
                            ?>


                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-relatorio") || Yii::$app->user->can("relatorio")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-fw fa-desktop"></i> Relatório', ['/relatorio/index']) ?>

                            </li>

                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->can("index-compra") || Yii::$app->user->can("compra")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-shopping-cart"></i> Compras', ['/compra/index']) ?>

                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->can("index-cardapio") || Yii::$app->user->can("cardapio")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa fa-list"></i> Cardápio', ['/cardapio/index']) ?>

                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-categoria") || Yii::$app->user->can("categoria")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-tags"></i> Categorias de Produto', ['/categoria/index']) ?>

                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-destaque") || Yii::$app->user->can("destaque")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-shopping-basket"></i> Destaque', ['/destaque/index']) ?>

                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->can("index-pedido") || Yii::$app->user->can("pedido")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-hand-o-up"></i> Pedidos', ['/pedido/index']) ?>

                            </li>
                            <?php
                        }
                        ?>


                        <?php
                        if (Yii::$app->user->can("index-historicosituacao") || Yii::$app->user->can("historicosituacao")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-shopping-basket"></i> HIstórico Situação', ['/historicosituacao/index']) ?>

                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->can("index-itemcardapio") || Yii::$app->user->can("itemcardapio")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-shopping-basket"></i> Item Cardapio', ['/itemcardapio/index']) ?>

                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-conta") || Yii::$app->user->can("conta")) {
                            ?>

                            <li>
                                <a href="javascript:;" data-toggle="collapse" data-target="#conta"><i
                                        class="fa fa-barcode"></i> Contas <i
                                        class="fa fa-fw fa-caret-down"></i></a>
                                <ul id="conta" class="collapse">
                                    <li>
                                        <?= Html::a('<i class="fa fa-barcode"></i> Todas as Contas', ['/conta/index']) ?>

                                    </li>
                                    <?php
                                    if (Yii::$app->user->can("index-contasapagar") || Yii::$app->user->can("contasapagar")) {
                                        ?>
                                        <li>
                                            <?= Html::a('<i class="fa fa-credit-card-alt"></i> Contas a Pagar', ['/contasapagar/index']) ?>

                                        </li>
                                        <?php
                                    }
                                    ?>


                                    <?php
                                    if (Yii::$app->user->can("index-contasapagar") || Yii::$app->user->can("contasapagar")) {
                                        ?>
                                        <li>
                                            <?= Html::a('<i class="fa fa-thumb-tack"></i> Custos Fixos', ['/custofixo/index']) ?>

                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if (Yii::$app->user->can("index-contasareceber") || Yii::$app->user->can("contasareceber")) {
                                        ?>
                                        <li>
                                            <?= Html::a('<i class="fa fa-dollar"></i> Contas a Receber', ['/contasareceber/index']) ?>

                                        </li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </li>

                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-loja") || Yii::$app->user->can("loja")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-shopping-basket"></i> Loja', ['/loja/index']) ?>

                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->can("index-mesa") || Yii::$app->user->can("mesa")) {
                            ?>
                            <li>
                                <?= Html::a('<i class="fa fa-table"></i> Mesa', ['/mesa/index']) ?>

                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("index-produto") || Yii::$app->user->can("produto")) {
                            ?>

                            <li>
                                <a href="javascript:;" data-toggle="collapse" data-target="#produto"><i
                                        class="fa fa-shopping-basket"></i> Produtos <i
                                        class="fa fa-fw fa-caret-down"></i></a>
                                <ul id="produto" class="collapse">
                                    <li>
                                        <?= Html::a('<i class="fa fa-list"></i> Todos os Produtos', ['/produto/index']) ?>

                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-list"></i> Insumos de Produtos de Venda', ['/produto/listadeinsumos']) ?>

                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-list"></i> Produtos de Venda por Insumo', ['/produto/listadeprodutosporinsumo']) ?>

                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-pagelines"></i> Todos os Insumos', ['/insumo/index']) ?>

                                    </li>

                                    <li>
                                        <?= Html::a('<i class="fa fa-spoon"></i> Todos os Produtos de Venda', ['/produto/produtosvenda']) ?>

                                    </li>
                                </ul>
                            </li>

                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::$app->user->can("user") || Yii::$app->user->can("admin") || Yii::$app->user->can("index-user")
                        ) {
                            ?>

                            <?php
                            if (Yii::$app->user->can("admin")) {
                                ?>
                                <li>
                                    <?= Html::a('<i class="fa fa-users"></i> Usuários', ['/user/admin']) ?>

                                </li>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <?= Html::a('<i class="fa fa-users"></i> Usuários', ['/user/']) ?>

                                </li>
                                <?php
                            }
                            ?>


                            <?php
                        }
                        ?>
                    </ul>
                </div>


                <?php
                }
                ?>

                <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>

                </div>
            </div>
            <!-- /.row -->
            <!-- conteudo das págians-->
            <div class="row">
                <div class="col-lg-12">
                    <?= $content ?>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <p class="pull-left">&copy; Sistema de Gerência de Lanchonete <?= date('Y') ?></p>

                    <p class="pull-right"><?= Yii::powered() ?></p>
                </div>
            </footer>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?=
//<!-- jQuery -->
$this->registerJsFile('@web/admin/js/jquery.js');
$this->registerJsFile('@web/admin/js/bootstrap.min.js');
//<!-- Morris Charts JavaScript -->
$this->registerJsFile('@web/admin/js/plugins/morris/raphael.min.js');
$this->registerJsFile('@web/admin/js/plugins/morris/morris.min.js');
$this->registerJsFile('@web/admin/js/plugins/morris/morris-data.js');
?>




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
