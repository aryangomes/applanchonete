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
class RelatorioController extends Controller
{

    private $tiposRelatorio = [

        'Contasareceber' => 'Contas a Receber',
        'Pagamento' => 'Pagamento',
        'Pedido' => 'Pedidos',
        'Itempedido' => 'Item(ns) Pedido',
        'Lucro' => 'Lucro',
    ];

    public function behaviors()
    {
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
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'relatorio' => [
                        'index-relatorio',
                        'update-relatorio',
                        'delete-relatorio',
                        'view-relatorio',
                        'create-relatorio',
                        'relatoriocontasareceber',
                        'relatoriopagamento',
                        'relatoriopedido',
                        'relatorioitempedido',
                        'relatoriolucro',
                        'pdfcontasareceber',
                        'pdfpagamento',
                        'pdfpedido',
                        'pdfitempedido',
                        'pdflucro',
                    ],

                    'index' => 'index-relatorio',
                    'update' => 'update-relatorio',
                    'delete' => 'delete-relatorio',
                    'view' => 'view-relatorio',
                    'create' => 'create-relatorio',
                    'relatoriocontasareceber' => 'relatoriocontasareceber',
                    'relatoriopagamento' => 'relatoriocontasareceber',
                    'relatoriopedido' => 'relatoriocontasareceber',
                    'relatorioitempedido' => 'relatoriocontasareceber',
                    'relatoriolucro' => 'relatoriocontasareceber',
                    'pdfcontasareceber' => 'relatoriocontasareceber',
                    'pdfpagamento' => 'relatoriocontasareceber',
                    'pdfpedido' => 'relatoriocontasareceber',
                    'pdfitempedido' => 'relatoriocontasareceber',
                    'pdflucro' => 'relatoriocontasareceber',

                ],
            ],
        ];
    }

    /**
     * Lists all Relatorio models.
     * @return mixed
     */
    public function actionIndex()
    {

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
    public function actionView($id)
    {
        $modelRelatorio = $this->findModel($id);

//        $tipoDeRelatorio ="\\app\\modelRelatorios\\".$model->tipo;


        return $this->render('view', [
            'modelRelatorio' => $modelRelatorio,
        ]);
    }

    /**
     * Creates a new Relatorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $modelRelatorio = new Relatorio();

        if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
            return $this->redirect(['relatorio' . strtolower($modelRelatorio->tipo), 'id' => $modelRelatorio->idrelatorio]);
        } else {
            $modelRelatorio->inicio_intervalo = date('Y-m-d');
            $modelRelatorio->fim_intervalo = date('Y-m-d');
            return $this->render('create', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
            ]);
        }
    }

    /**
     * Updates an existing Relatorio modelRelatorio.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $modelRelatorio = $this->findModel($id);

        if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
            return $this->redirect(['relatorio' . strtolower($modelRelatorio->tipo), 'id' => $modelRelatorio->idrelatorio]);
        } else {
            return $this->render('update', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
            ]);
        }
    }

    /**
     * Deletes an existing Relatorio modelRelatorio.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //Guarda a mensagem
        $mensagem = "";

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($this->findModel($id)->delete()) {
                $transaction->commit();
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
        }

        $searchModel = new RelatorioSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);
    }

    /**
     * Finds the Relatorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Relatorio the loaded modelRelatorio
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelRelatorio = Relatorio::findOne($id)) !== null) {
            return $modelRelatorio;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriocontasareceber($id = null)
    {

        $modelRelatorio = new Relatorio();


        if (Yii::$app->request->post()) {
            $modelRelatorio = $this->findModel($id);
            if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
                return $this->redirect(['relatoriocontasareceber', 'id' => $modelRelatorio->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriocontasareceber', [
                    'modelRelatorio' => $modelRelatorio,
                    'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }

            $searchContasAReceber = new ContasareceberSearch();
            $modelRelatorio = $this->findModel($id);

            return $this->render('relatoriocontasareceber', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
                'tipoRelatorio' => $this->tiposRelatorio[$modelRelatorio->tipo],
                'datasContasAReceber' => $searchContasAReceber->searchDatasContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
                'valoresContasAReceber' => $searchContasAReceber->searchContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriopagamento($id = null)
    {

        $modelRelatorio = new Relatorio();


        if (Yii::$app->request->post()) {
            $modelRelatorio = $this->findModel($id);
            if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
                return $this->redirect(['relatoriopagamento', 'id' => $modelRelatorio->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriopagamento', [
                    'modelRelatorio' => $modelRelatorio,
                    'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchPagamento = new PagamentoSearch();

            $modelRelatorio = $this->findModel($id);

            return $this->render('relatoriopagamento', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
                'tipoRelatorio' => $this->tiposRelatorio[$modelRelatorio->tipo],
                'countTiposPagamentos' => $searchPagamento->searchCountPagamentosContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
                'datasPagamentos' => $searchPagamento->searchDatasPagamentosContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
                'tiposPagamentos' => $searchPagamento->searchPagamentosContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriopedido($id = null)
    {

        $modelRelatorio = new Relatorio();


        if (Yii::$app->request->post()) {
            $modelRelatorio = $this->findModel($id);
            if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
                return $this->redirect(['relatoriopedido', 'id' => $modelRelatorio->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriopedido', [
                    'modelRelatorio' => $modelRelatorio,
                    'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchPedido = new PedidoSearch();

            $modelRelatorio = $this->findModel($id);


            return $this->render('relatoriopedido', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
                'tipoRelatorio' => $this->tiposRelatorio[$modelRelatorio->tipo],
                'pedidos' => $searchPedido->searchCountPedidosContasAReceberPorPeriodo($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatorioitempedido($id = null)
    {

        $modelRelatorio = new Relatorio();


        if (Yii::$app->request->post()) {
            $modelRelatorio = $this->findModel($id);
            if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
                return $this->redirect(['relatorioitempedido', 'id' => $modelRelatorio->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatorioitempedido', [
                    'modelRelatorio' => $modelRelatorio,
                    'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchItemPedido = new ItempedidoSearch();

            $modelRelatorio = $this->findModel($id);


            return $this->render('relatorioitempedido', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
                'tipoRelatorio' => $this->tiposRelatorio[$modelRelatorio->tipo],
                'produtosVendidos' => $searchItemPedido->searchItensPedido($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
            ]);
        }
    }

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRelatoriolucro($id = null)
    {

        $modelRelatorio = new Relatorio();


        if (Yii::$app->request->post()) {
            $modelRelatorio = $this->findModel($id);
            if ($modelRelatorio->load(Yii::$app->request->post()) && $modelRelatorio->save()) {
                return $this->redirect(['relatoriolucro', 'id' => $modelRelatorio->idrelatorio]);
            }
        } else {
            if ($id == null) {
                return $this->render('relatoriolucro', [
                    'modelRelatorio' => $modelRelatorio,
                    'tiposRelatorio' => $this->tiposRelatorio
                ]);
            }


            $searchItemPedido = new ItempedidoSearch();

            $modelRelatorio = $this->findModel($id);


            return $this->render('relatoriolucro', [
                'modelRelatorio' => $modelRelatorio,
                'tiposRelatorio' => $this->tiposRelatorio,
                'tipoRelatorio' => $this->tiposRelatorio[$modelRelatorio->tipo],
                'lucros' => $searchItemPedido->searchLucro($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
            ]);
        }
    }

    public function actionPdfcontasareceber($id = null)
    {
        if ($id != null) {

            $searchContasAReceber = new ContasareceberSearch();
            $modelRelatorio = $this->findModel($id);
            $dadosContasAReceber = [$searchContasAReceber->searchDatasContasAReceberPorPeriodo
            ($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo),
                $searchContasAReceber->searchContasAReceberPorPeriodo
                ($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo)
            ];

//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'content' => $this->renderPartial('pdfcontasareceber', [
                    'modelRelatorio' => $modelRelatorio,
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

    public function actionPdfpagamento($id = null)
    {
        if ($id != null) {

            $searchPagamento = new PagamentoSearch();

            $modelRelatorio = $this->findModel($id);

            $dadosPagamento = $searchPagamento->searchPagamentosContasAReceberPorPeriodo
            ($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo);


//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial('pdfpagamento', [
                    'modelRelatorio' => $modelRelatorio,
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

    public function actionPdfpedido($id = null)
    {
        if ($id != null) {

            $searchPedido = new PedidoSearch();

            $modelRelatorio = $this->findModel($id);

            $dadosPedido = $searchPedido->searchCountPedidosContasAReceberPorPeriodo
            ($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo);


//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial('pdfpedido', [
                    'modelRelatorio' => $modelRelatorio,
                    'dadosPedido' => $dadosPedido,
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

    public function actionPdfitempedido($id = null)
    {
        if ($id != null) {

            $searchItemPedido = new ItempedidoSearch();

            $modelRelatorio = $this->findModel($id);


            $dadosItemPedido = $searchItemPedido->searchItensPedido($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo);


//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial('pdfitempedido', [
                    'modelRelatorio' => $modelRelatorio,
                    'dadosItemPedido' => $dadosItemPedido,
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

    public function actionPdflucro($id = null)
    {
        if ($id != null) {

            $searchItemPedido = new ItempedidoSearch();

            $modelRelatorio = $this->findModel($id);


            $dadosLucro = $searchItemPedido->searchLucro($modelRelatorio->inicio_intervalo, $modelRelatorio->fim_intervalo);


//         Setando a data para o fuso do Brasil
            date_default_timezone_set('America/Sao_Paulo');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial('pdflucro', [
                    'modelRelatorio' => $modelRelatorio,
                    'dadosLucro' => $dadosLucro,
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
