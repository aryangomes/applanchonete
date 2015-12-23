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
use app\models\Despesa;
use app\models\Caixa;
use yii\helpers\Url;
AppAsset::register($this);

$formatter = \Yii::$app->formatter;
$caixa = new Caixa();
$caixa = $caixa::find('*')->one();

$despesa = new Despesa();
$despesasNaoPagas = $despesa::find('*')->where('situacaopagamento=0')->all();
$valorDespesas = $despesa::find('*')->where('situacaopagamento=0')->sum('valordespesa');

$loja = Loja::find()->all();

if (count($loja) > 0) {
    foreach ($loja as $l) {
     $nomeLoja = $l->nome;
     $url =Url::toRoute(['/loja/view', 'id'=>$nomeLoja]);
 }

}else{
   $nomeLoja = 'Cadastre sua loja';
   $url =Url::toRoute(['/loja/create']);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
    <?php $this->beginBody() ?>

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
                <?= Html::a('Sigir', ['site/index'], ['class' => 'navbar-brand']) ?>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="<?= $url  ?>"><?= $nomeLoja ?> </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i> 
                        <?php
                        if (count($despesasNaoPagas) > 0) {
                            ?> <span class="label label-danger">
                            <?= count($despesasNaoPagas) ?>

                        </span>
                        <b class="caret"></b></a>
                        <ul class="dropdown-menu message-dropdown">
                            <?php 
                            foreach ($despesasNaoPagas as  $despesa) {


                                ?>
                                <li >
                                    <a href="<?= Url::toRoute(['/despesa/view', 'id'=>$despesa->iddespesa]) ?>"><?= 'Despesa: '.$despesa->nomedespesa .
                                    '(Data Vencimento: ' . $formatter->asDate( $despesa->datavencimento,'dd/MM/yyyy') . ') ' ?></a>
                                </li>
                                <li class="divider"></li>
                                <?php 
                            }
                            ?>

                            
                            <li >
                                <a href="<?= Url::toRoute(['/despesa/index']) ?>">Todas as despesas não pagas</a>
                            </li>
                        </ul>
                        <?php
                    }else{
                        ?>
                        <b class="caret"></b></a>
                        <ul class="dropdown-menu message-dropdown">
                          <li >
                            Não há despesas para serem pagas
                        </li>
                    </ul>
                    <?php 
                }
                ?>

            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <?php
                    if ($caixa->valoremcaixa < $valorDespesas) {


                        ?>
                        <i class="fa fa-bell"></i>
                        <span class="label label-danger">
                           !
                       </span>
                       <b class="caret"></b></a>
                       <ul class="dropdown-menu alert-dropdown">


                           <li>
                              &nbsp; Há um déficit no caixa </li>
                              <?php     
                          } else {
                            ?>
                            <i class="fa fa-bell"></i>
                            
                            <b class="caret"></b></a>
                            <ul class="dropdown-menu alert-dropdown">
                                <li>
                                    &nbsp; Não há alertas  </li>
                                    <?php

                                }?>




                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

                    <div class="collapse navbar-collapse navbar-ex1-collapse ">
                        <ul class="nav navbar-nav side-nav">
                            <li class="active">
                                <?= Html::a('<i class="fa fa-fw fa-home"></i> Home', ['site/index']) ?>

                            </li>
                            <li>
                                <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> Despesas', ['despesa/index']) ?>

                            </li>
                            <li>
                                <?= Html::a('<i class="fa fa-money"></i> Caixa', ['caixa/index']) ?>

                            </li>
                <!--     <li>
                        <?php // Html::a('<i class="fa fa-fw fa-table"></i> Loja', ['loja/index']) ?>
                    </li> -->
                    <li>
                        <?= Html::a('<i class="fa fa-truck"></i> Fornecedor', ['fornecedor/index']) ?>

                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-fw fa-desktop"></i> Relatório', ['relatorio/index']) ?>

                    </li>

                    <li>
                        <?= Html::a('<i class="fa fa-shopping-basket"></i> Compras', ['compra/index']) ?>

                    </li>

                </ul>
            </div>
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
                    <footer class="footer" >
                        <div class="container">
                            <p class="pull-left">&copy; Sigir <?= date('Y') ?></p>

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
