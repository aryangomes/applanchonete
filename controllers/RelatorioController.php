<?php

namespace app\controllers;

use app\models\Contasareceber;
use app\models\ContasareceberSearch;
use app\models\Pagamento;
use app\models\PagamentoSearch;
use app\models\PedidoSearch;
use Yii;
use app\models\Relatorio;
use app\models\RelatorioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;
use \app\models\Itempedido;
use kartik\mpdf\Pdf;
use \app\models\ItempedidoSearch;

/**
 * RelatorioController implements the CRUD actions for Relatorio model.
 */
class RelatorioController extends Controller {

    private $tiposRelatorio = [

        'Contasareceber' => 'Contas a Receber',
        'Pagamento' => 'Pagamento',
        'Pedido' => 'Pedidos',
        'Itempedido' => 'Item(ns) Pedido',
         'Lucro' => 'Lucro',
    ];

    public function behaviors() {
        return [
            /* 'access' =>[
              'class' => AccessControl::classname(),
              'only'=> ['create','update','view','delete','index'],
              'rules'=> [
              ['allow'=>true,
              'roles' => ['relatorio','index-relatorio'],
              ],
              ]
              ], */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
                /* 'autorizacao' => [
                  'class' => AccessFilter::className(),
                  'actions' => [

                  'relatorio' => [
                  'index-relatorio',
                  'update-relatorio',
                  'delete-relatorio',
                  'view-relatorio',
                  'create-relatorio',
                  'relatorio-contasa-receber',
                  ],

                  'index' => 'index-relatorio',
                  'update' => 'update-relatorio',
                  'delete' => 'delete-relatorio',
                  'view' => 'view-relatorio',
                  'create' => 'create-relatorio',

                  ],
                  ], */
        ];
    }

    /**
     * Lists all Relatorio models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new RelatorioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Relatorio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

//        $tipoDeRelatorio ="\\app\\models\\".$model->tipo;


        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Relatorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Relatorio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['relatorio' . strtolower($model->tipo), 'id' => $model->idrelatorio]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
            ]);
        }
    }

    /**
     * Updates an existing Relatorio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['relatorio' . strtolower($model->tipo), 'id' => $model->idrelatorio]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
            ]);
        }
    }

    /**
     * Deletes an existing Relatorio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Relatorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Relatorio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Relatorio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriocontasareceber($id = null) {

        $model = new Relatorio();



        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['relatoriocontasareceber', 'id' => $model->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriocontasareceber', [
                            'model' => $model,
                            'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }

            $searchContasAReceber = new ContasareceberSearch();
            $model = $this->findModel($id);
            return $this->render('relatoriocontasareceber', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
                        'datasContasAReceber' => $searchContasAReceber->searchDatasContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
                        'valoresContasAReceber' => $searchContasAReceber->searchContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriopagamento($id = null) {

        $model = new Relatorio();



        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['relatoriopagamento', 'id' => $model->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriopagamento', [
                            'model' => $model,
                            'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchPagamento = new PagamentoSearch();

            $model = $this->findModel($id);

            return $this->render('relatoriopagamento', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
                        'countTiposPagamentos' => $searchPagamento->searchCountPagamentosContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
                        'datasPagamentos' => $searchPagamento->searchDatasPagamentosContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
                        'tiposPagamentos' => $searchPagamento->searchPagamentosContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriopedido($id = null) {

        $model = new Relatorio();



        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['relatoriopedido', 'id' => $model->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriopedido', [
                            'model' => $model,
                            'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchPedido = new PedidoSearch();

            $model = $this->findModel($id);


            return $this->render('relatoriopedido', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
                        'pedidos' => $searchPedido->searchCountPedidosContasAReceberPorPeriodo($model->inicio_intervalo, $model->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatorioitempedido($id = null) {

        $model = new Relatorio();



        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['relatorioitempedido', 'id' => $model->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatorioitempedido', [
                            'model' => $model,
                            'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchItemPedido = new ItempedidoSearch();

            $model = $this->findModel($id);


            return $this->render('relatorioitempedido', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
                        'produtosVendidos' => $searchItemPedido->searchItensPedido($model->inicio_intervalo, $model->fim_intervalo),
            ]);
        }
    }
    
      /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriolucro($id = null) {

        $model = new Relatorio();



        if (Yii::$app->request->post()) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['relatoriolucro', 'id' => $model->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriolucro', [
                            'model' => $model,
                            'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchItemPedido = new ItempedidoSearch();

            $model = $this->findModel($id);


            return $this->render('relatoriolucro', [
                        'model' => $model,
                        'tiposRelatorio' => $this->tiposRelatorio,
                        'lucros' => $searchItemPedido->searchLucro($model->inicio_intervalo, $model->fim_intervalo),
            ]);
        }
    }

    public function actionPdfcontasareceber($id = null) {
        if ($id != null) {

            $searchContasAReceber = new ContasareceberSearch();
            $model = $this->findModel($id);
            $dadosContasAReceber = [$searchContasAReceber->searchDatasContasAReceberPorPeriodo
                        ($model->inicio_intervalo, $model->fim_intervalo),
                $searchContasAReceber->searchContasAReceberPorPeriodo
                        ($model->inicio_intervalo, $model->fim_intervalo)
            ];

//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'content' => $this->renderPartial('pdfcontasareceber', [
                    'model' => $model,
                    'dadosContasAReceber' => $dadosContasAReceber,
                ]),
                'options' => [
                    'title' => 'Relatório de Contas a Receber',
                ],
                'methods' => [
                    'SetHeader' => ['Gerado pelo Componente "Krajee Pdf" ||Gerado em: ' . date('d/m/Y h:m:s')],
                    'SetFooter' => ['|Página {PAGENO}|'],
                ]
            ]);
            return $pdf->render();
        } else {
            $searchModel = new RelatorioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionPdfpagamento($id = null) {
        if ($id != null) {

            $searchPagamento = new PagamentoSearch();

            $model = $this->findModel($id);

            $dadosPagamento = $searchPagamento->searchPagamentosContasAReceberPorPeriodo
                    ($model->inicio_intervalo, $model->fim_intervalo);



//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, 
                'content' => $this->renderPartial('pdfpagamento', [
                    'model' => $model,
                    'dadosPagamento' => $dadosPagamento,
                ]),
                'options' => [
                    'title' => 'Relatório de Pagamentos',
                ],
                'methods' => [
                    'SetHeader' => ['Gerado pelo Componente "Krajee Pdf" ||Gerado em: ' . date('d/m/Y h:m:s')],
                    'SetFooter' => ['|Página {PAGENO}|'],
                ]
            ]);
            return $pdf->render();
        } else {
            $searchModel = new RelatorioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }
    
    public function actionPdfpedido($id = null) {
        if ($id != null) {

         $searchPedido = new PedidoSearch();

            $model = $this->findModel($id);

            $dadosPedido =  $searchPedido->searchCountPedidosContasAReceberPorPeriodo
                    ($model->inicio_intervalo, $model->fim_intervalo);
      



//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, 
                'content' => $this->renderPartial('pdfpedido', [
                    'model' => $model,
                    'dadosPedido' => $dadosPedido ,
                ]),
                'options' => [
                    'title' => 'Relatório de Pedidos Feitos',
                ],
                'methods' => [
                    'SetHeader' => ['Gerado pelo Componente "Krajee Pdf" ||Gerado em: ' . date('d/m/Y h:m:s')],
                    'SetFooter' => ['|Página {PAGENO}|'],
                ]
            ]);
            return $pdf->render();
        } else {
            $searchModel = new RelatorioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }
    
    public function actionPdfitempedido($id = null) {
        if ($id != null) {

         $searchItemPedido = new ItempedidoSearch();

            $model = $this->findModel($id);


           $dadosItemPedido = $searchItemPedido->searchItensPedido($model->inicio_intervalo, $model->fim_intervalo);



//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, 
                'content' => $this->renderPartial('pdfitempedido', [
                    'model' => $model,
                    'dadosItemPedido' => $dadosItemPedido ,
                ]),
                'options' => [
                    'title' => 'Relatório de Quantidade de Produtos Vendidos',
                ],
                'methods' => [
                    'SetHeader' => ['Gerado pelo Componente "Krajee Pdf" ||Gerado em: ' . date('d/m/Y h:m:s')],
                    'SetFooter' => ['|Página {PAGENO}|'],
                ]
            ]);
            return $pdf->render();
        } else {
            $searchModel = new RelatorioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }
    
    public function actionPdflucro($id = null) {
        if ($id != null) {

         $searchItemPedido = new ItempedidoSearch();

            $model = $this->findModel($id);


           $dadosLucro = $searchItemPedido->searchLucro($model->inicio_intervalo, $model->fim_intervalo);



//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, 
                'content' => $this->renderPartial('pdflucro', [
                    'model' => $model,
                    'dadosLucro' => $dadosLucro ,
                ]),
                'options' => [
                    'title' => 'Relatório de Lucro por Data',
                ],
                'methods' => [
                    'SetHeader' => ['Gerado pelo Componente "Krajee Pdf" ||Gerado em: ' . date('d/m/Y h:m:s')],
                    'SetFooter' => ['|Página {PAGENO}|'],
                ]
            ]);
            return $pdf->render();
        } else {
            $searchModel = new RelatorioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

}
