<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Pedido: ' . $model->idPedido . ' | Situação Atual: ' . $model->situacaopedido->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="pedido-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?php

            echo ($model->situacaopedido->titulo != 'Concluído') ? Html::a(Yii::t('yii', 'Update'),
                ['update', 'id' => $model->idPedido], ['class' => 'btn btn-primary']) : '' ?>
            <?php

            echo ($model->situacaopedido->titulo != 'Concluído') ? Html::a(Yii::t('app', 'Delete'),
                ['delete', 'id' => $model->idPedido], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) : '' ?>

            <!--   ---------------------------   BEGIN Finalizar Pedido  ---------------------------  -->
            <?php
            Modal::begin([
                'header' => '<h2>Finalizar Pedido</h2>',
                'id' => 'modalfinalizarpedido',

                'toggleButton' => ($model->situacaopedido->titulo != 'Concluído') ?
                    ['label' => 'Finalizar Pedido',
                        'class' => 'btn btn-warning',
                        'disabled' => isset($model->datadevolucao) ? true : false] : false,
            ]);
            ?>
        <div class="row">
            <div class="col-lg-6">
                <?= Html::label("Forma Pagamento", ['class' => 'form-control'])
                ?>
                <div class="input-group">

                    <?=
                    Html::dropDownList("Formapagamento", 1, $formasPagamento, ['class' => 'form-control',
                        'id' => 'formapagamento',
                        'prompt' => 'Escolha uma forma de pagamento'])
                    ?>
                    <?= Html::hiddenInput('Pedido[idPedido]', $model->idPedido, [
                        'id' => 'idpedido',
                    ]) ?>
                    <span class="input-group-btn">
                        <?=
                        Html::Button("Finalizar Pedido", ['class' => 'btn btn-success',
                            'id' => 'btFinalizarPedido'])
                        ?>
                    </span>


                </div>
                <?= Html::label("Valor Total", ['class' => 'form-control'])
                ?>
                <?=
                Html::input('text', null, isset($model->totalPedido) ? 'R$ ' . $model->totalPedido : ''
                    , ['class' => 'form-control',
                        'disabled' => true,])

                ?>
            </div>

        </div>


        <?php
        Modal::end();
        ?>

        <!--   ---------------------------   END Finalizar Pedido  ---------------------------  -->

        </p>
        <?php
        $this->registerJsFile(\Yii::getAlias("@web") . '/js/pedido_view.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'idPedido',

                ['attribute' => 'totalPedido',

                    'value' => 'R$ ' . $model->totalPedido
                ],
                
                ['attribute' => 'idMesa',
                    'label' => 'Mesa',
                    'value' => $model->idMesa
                ],

                ['attribute' => 'situacaopedido',
                    'label' => 'Situação Atual',
                    'value' => $model->situacaopedido->titulo
                ],
            ],
        ]) ?>

    </div>

    <div id="mensagem-finalizar-pedido"></div>

<?php
if (count($itensPedido) > 0) {
    ?>
    <p class="row"><h1>Itens do Pedido</h1></p>
    <table class="table table-striped table-bordered detail-view">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Total Produto</th>
        </tr>
        </thead>
        <tbody id="tbody-result-rg">
        <?php
        foreach ($itensPedido[0]['itempedidos'] as $ip) {
            ?>
            <tr>
                <td><?= $ip['produto']->nome ?></td>
                <td><?= $ip->quantidade ?></td>
                <td><?= 'R$ ' . number_format(($ip->quantidade *
                        $ip['produto']->valorVenda), 2) ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <?php
}
?>
<?php //var_dump($itensPedido) 

?>