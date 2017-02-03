<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $modelPedido app\models\Pedido */

$this->title = 'Pedido: ' . $modelPedido->idPedido . ' | Situação Atual: ' . $modelPedido->situacaopedido->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$modelPedido->getItensPedido($modelPedido->idPedido);
?>
    <div class="pedido-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?php

            echo ($modelPedido->situacaopedido->idSituacaoPedido == 1) ? Html::a(Yii::t('yii', 'Update'),
                ['update',  'id' => $modelPedido->idPedido,
                  ], ['class' => 'btn btn-primary',
                    'title'=>'Clique para ir para a tela de alteração dos dados do Pedido']) : '' ?>
            <?php

         ?>

            <!--   ---------------------------   BEGIN Finalizar Pedido  ---------------------------  -->
            <?php
            Modal::begin([
                'header' => '<h2>Finalizar Pedido</h2>',
                'id' => 'modalfinalizarpedido',

                'toggleButton' => ($modelPedido->situacaopedido->idSituacaoPedido == 1) ?
                    ['label' => 'Finalizar Pedido',
                        'class' => 'btn btn-warning',
                        'title'=>'Clique para finalizar o Pedido',
                        'disabled' => isset($modelPedido->datadevolucao) ? true : false] : false,
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
                    <?= Html::hiddenInput('Pedido[idPedido]', $modelPedido->idPedido, [
                        'id' => 'idpedido',
                    ]) ?>
                    <span class="input-group-btn">
                        <?=
                        Html::button("Finalizar Pedido", ['class' => 'btn btn-success',
                            'id' => 'btFinalizarPedido'])
                        ?>
                    </span>


                </div>
                <?= Html::label("Valor Total", ['class' => 'form-control'])
                ?>
                <?=
                Html::input('text', null, isset($modelPedido->totalPedido) ? 'R$ ' . $modelPedido->totalPedido : ''
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
            'model' => $modelPedido,
            'attributes' => [
                'idPedido',

                ['attribute' => 'totalPedido',

                    'value' => 'R$ ' . $modelPedido->totalPedido
                ],
                
                ['attribute' => 'idMesa',
                    'label' => 'Mesa',
                    'value' => $modelPedido->idMesa
                ],

                ['attribute' => 'situacaopedido',
                    'label' => 'Situação Atual',
                    'value' => $modelPedido->situacaopedido->titulo
                ],
                [
                    'attribute' => 'historicosituacaos.user.username',
                    'label'=>'Registrado por',
                    'value' => $modelPedido->historicosituacaos->user->username,

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
