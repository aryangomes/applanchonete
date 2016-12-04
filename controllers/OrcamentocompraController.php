<?php

namespace app\controllers;

use app\components\AccessFilter;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\OrcamentoCompra;

class OrcamentocompraController extends Controller
{

    public function behaviors()
    {
        return [
//            'access' => [
//        'class' => AccessControl::classname(),
//        'only'=> ['create','update','view','delete','index'],
//        'rules'=> [
//        ['allow'=>true,
//        'roles' => ['mesa','index-mesa'],
//        ],
//        ]
//        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
//            ],
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'produto' => [
                        'orcamentocomprainsumos' => 'produto',
                    ],

                    'orcamentocomprainsumos' => 'produto',

                ],
            ],
        ];
    }

    public function actionOrcamentocomprainsumos()
    {
        $model = new OrcamentoCompra();
        $post = \Yii::$app->request->post();

        if ($model->load($post)) {

            $model->listaInsumos = $post['OrcamentoCompra']['listaInsumos'];

            $resultados = array();

            $valororcamento = 0;

            foreach ($model->listaInsumos as $lista) {
                $result = Yii::$app->db->createCommand('SELECT * FROM produto WHERE idProduto = :id', ['id' => $lista])->queryAll();

                array_push($resultados, $result);

            }

            $valorTotal = 0;

            foreach ($resultados as $res) {

                $valororcamento = array_column($res, 'valorVenda');

                $valorFloat = (float)$valororcamento[0];

                $valorTotal += $valorFloat;
            }


            return $this->render('resultadoorcamento', [
                'model' => $model,
                'valorTotal' => $valorTotal,
            ]);

        } else {

            $listaInsumosCadastrados = Yii::$app->db->createCommand('SELECT idProduto, nome FROM produto')->queryAll();

            return $this->render('orcamentocomprainsumos', [
                'model' => $model,
                'listaInsumosCadastrados' => $listaInsumosCadastrados,
            ]);
        }
    }
}
