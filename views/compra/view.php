<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelCompra app\models\Compra */
/* @var $compraProdutos array */
$this->title = 'Compra do dia ' . date("d/m/Y", strtotime($modelCompra->dataCompra));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="compra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelCompra->idconta], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados da Compra']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelCompra->idconta], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar essa Compra',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>


    </br>
    <table id="w0" class="table table-striped table-bordered detail-view">
        <p>
            <trhead><b>Lista de Produtos comprados</b></trhead>
        </p>
        <tbody>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço</th>
        <th>Valor Total</th>
        <?php foreach ($compraProdutos as $key => $cp) {
            ?>

            <tr>

                <td><?= $cp->produto->nome ?></td>
                <td><?= $cp->quantidade ?></td>
                <td><?= 'R$ ' . $cp->valorCompra ?></td>
                <td>-</td>
            </tr>
            <?php

        }
        ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?= 'R$ ' . $modelCompra->conta->valor ?></td>
        </tr>
        </tbody>
    </table>


</div>
