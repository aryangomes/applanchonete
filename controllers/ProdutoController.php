<?php

namespace app\controllers;

use Yii;
use app\models\Produto;
use app\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Categoria;
use app\models\Insumo;
use app\models\Itempedido;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'produto' => [
                        'index-produto',
                        'update-produto',
                        'delete-produto',
                        'view-produto',
                        'create-produto',
                        'listadeinsumos',
                        'avaliacaoproduto',
                        'listadeprodutosporinsumo',
                        'produtosvenda',
                        'cadastrarprodutovenda',
                        'alterarprodutovenda',
                        'definirvalorprodutovenda',
                    ],

                    'index' => 'index-produto',
                    'update' => 'update-produto',
                    'delete' => 'delete-produto',
                    'view' => 'view-produto',
                    'create' => 'create-produto',
                    'avaliacaoproduto' => 'avaliacaoproduto',
                    'listadeinsumos' => 'listadeinsumos',
                    'listadeprodutosporinsumo' => 'listadeprodutosporinsumo',
                    'produtosvenda' => 'produtosvenda',
                    'cadastrarprodutovenda' => 'cadastrarprodutovenda',
                    'alterarprodutovenda' => 'alterarprodutovenda',
                    'definirvalorprodutovenda' =>'definirvalorprodutovenda',
                ],
            ],
        ];
    }

    /**
     * Lists all Produto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProdutosvenda()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->searchProdutosVendaIndex(Yii::$app->request->queryParams);

        return $this->render('produtosvenda', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ProdutoSearch();
        $model = $this->findModel($id);
        if ($model->isInsumo) {
            return $this->render('view', [
                'model' => $model,

            ]);

        } else {
            $listadeinsumos = $searchModel->searchInsumos($id);

            $insumos = array();
            $produtoVenda = $this->findModel($id);


            /**
             * Cria e adiciona os Insumos de um Produto Venda
             * em um array
             */
            foreach ($listadeinsumos as $insumo) {
                array_push($insumos,
                    $insumo);

            }


            return $this->render('view', [
                'model' => $model,
                'insumos' => $insumos,
                'produtoVenda' => $produtoVenda,
            ]);
        }
    }

    /**
     * Retorna a lista de Insumos de um Produto Venda
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionListadeinsumos()
    {
        $model = new Produto();
        $produtosVenda = ArrayHelper::map(
            Produto::find()->join('INNER JOIN', 'insumo', 'idProduto = idprodutoVenda ')
                ->where(['isInsumo' => 0])->all(),
            'idProduto', 'nome');
        if ((Yii::$app->request->post())) {
            $searchModel = new ProdutoSearch();

            $listadeinsumos = $searchModel->searchInsumos(Yii::$app->request->post());

            $insumos = array();
            $model = $this->findModel(Yii::$app->request->post()['produtovenda']);
            foreach ($listadeinsumos as $insumo) {
                array_push($insumos,
                    $model::findOne($insumo->idprodutoInsumo));
            }

            return $this->render('listadeinsumos', [
                'insumos' => $insumos,
                'produtosVenda' => $produtosVenda,
                'model' => $model,
            ]);
        } else {

            return $this->render('listadeinsumos', [
                'produtosVenda' => $produtosVenda,

            ]);
        }
    }

    /**
     * Retorna a lista de Produtos Venda que possuem um determinado Insumo
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionListadeprodutosporinsumo()
    {
        $model = new Produto();
        $insumos = ArrayHelper::map(
            Produto::find()->join('INNER JOIN', 'insumo', 'idProduto = idprodutoInsumo ')
                ->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');
        if ((Yii::$app->request->post())) {
            $searchModel = new ProdutoSearch();

            $listadeprodutosvenda = $searchModel->searchProdutosVenda(Yii::$app->request->post());

            $nomeInsumo = $this->findModel(Yii::$app->request->post()['idinsumo'])->nome;


            $produtosVenda = array();

            foreach ($listadeprodutosvenda as $pv) {
                array_push($produtosVenda,
                    $model::findOne($pv->idprodutoVenda));
            }

            return $this->render('listadeprodutosporinsumo', [
                'insumos' => $insumos,
                'produtosVenda' => $produtosVenda,
                'nomeInsumo' => $nomeInsumo,
            ]);
        } else {

            return $this->render('listadeprodutosporinsumo', [
                'insumos' => $insumos,

            ]);
        }
    }


    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Produto();
        $insumo = new Insumo();
        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {



            if (!Yii::$app->request->post()['Produto']['isInsumo']) {
                $aux = Yii::$app->request->post()['Insumo'];
                $n = count($aux['idprodutoInsumo']);

                for ($i = 0; $i < $n; $i++) {

                    if (($aux['idprodutoInsumo'][$i]) > 0) {


                        Yii::$app->db->createCommand(
                            "INSERT INTO insumo
                    (idprodutoVenda, idprodutoInsumo,
                      quantidade,unidade ) 
                  VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                            ':idprodutoVenda' => $model->idProduto,
                            ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                            ':quantidade' => $aux['quantidade'][$i],
                            ':unidade' => $aux['unidade'][$i],
                        ])->execute();
                    }

                }

                $model->valorVenda = $model->calculoPrecoProduto($model->idProduto);
                $model->save(false);
                return $this->redirect(['definirvalorprodutovenda', 'idProduto' => $model->idProduto]);
            }

            return $this->redirect(['view', 'id' => $model->idProduto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categorias' => $categorias,
                'insumos' => $insumos,
                'insumo' => $insumo,
            ]);
        }
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $insumo = new Insumo();
        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');
        if (!$model->isInsumo) {
            $insumos = ArrayHelper::map(
                Produto::find()->where(['isInsumo' => 1])->all(),
                'idProduto', 'nome');
            $models = Insumo::find()->where(['idprodutoVenda' => $id])->all();

            $modelProdutoVenda = $this::findModel($id);
        }
        if ((Yii::$app->request->post())) {
            if (!$model->isInsumo) {
                if (isset(Yii::$app->request->post()['produto-valorvenda-disp'])) {
                    $model->valorVenda = Yii::$app->request->post()['Produto']['valorVenda'];
                    $model->idCategoria = Yii::$app->request->post()['Produto']['idCategoria'];
                    $model->save();
                }
                $aux = Yii::$app->request->post()['Insumo'];

                $n = count($aux['idprodutoInsumo']);

                Yii::$app->db->createCommand(
                    "DELETE FROM insumo WHERE idprodutoVenda = :idprodutoVenda", [
                    ':idprodutoVenda' => $id,
                ])->execute();
                for ($i = 0; $i < $n; $i++) {

                    if (($aux['idprodutoInsumo'][$i]) > 0) {

                        Yii::$app->db->createCommand(
                            "INSERT INTO insumo
                    (idprodutoVenda, idprodutoInsumo,
                      quantidade,unidade ) 
                  VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                            ':idprodutoVenda' => $id,
                            ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                            ':quantidade' => $aux['quantidade'][$i],
                            ':unidade' => $aux['unidade'][$i],
                        ])->execute();
                    }

                }
                $model->valorVenda = $model->calculoPrecoProduto($model->idProduto);
                $model->save(false);
            } else {
                $model->load(Yii::$app->request->post());
                $model->save();
            }
            return $this->redirect(['produto/view', 'id' => $id]);

        } else {
            if (!$model->isInsumo) {
                return $this->render('update', [
                    'model' => $model,
                    'models' => $models,
                    'categorias' => $categorias,
                    'insumos' => $insumos,
                    'insumo' => $insumo,
                    'modelProdutoVenda' => $modelProdutoVenda,

                    'idprodutoVenda' => $id,
                ]);
            }
            return $this->render('update', [
                'model' => $model,

                'categorias' => $categorias,

            ]);
        }
    }


    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();


        return $this->redirect(['index']);
    }


    /**
     * Gera um gráfico com as vendas de um Produto Venda
     * @param $idproduto
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionAvaliacaoproduto($idproduto)
    {
        $model = $this->findModel($idproduto);
        if (Yii::$app->request->post()) {

            $groupbyavaliacao = Yii::$app->request->post()['Produto']['groupbyavaliacao'];
            $datainicioavaliacao = Yii::$app->request->post()['datainicioavaliacao'];
            $datafimavaliacao = Yii::$app->request->post()['datafimavaliacao'];

            switch ($groupbyavaliacao) {
                case 'DAY':
                    $formatdate = 'd';
                    break;

                case 'MONTH':
                    $formatdate = 'm';
                    break;

                case 'YEAR':
                    $formatdate = 'Y';
                    break;
                default:
                    $formatdate = 'd';
                    break;
            }

            $vendas = Itempedido::find();

            $vendas
                ->select('*, sum(quantidade) as total, ' . $groupbyavaliacao . '(dataHora) as periodo')
                ->joinWith('produto')
                ->joinWith('pedido.pagamento.contasareceber.conta')
                ->andFilterWhere(['produto.idProduto' => $idproduto,])
                ->andFilterWhere(['>=', 'dataHora', $datainicioavaliacao])
                ->andFilterWhere(['<=', 'dataHora', $datafimavaliacao])
                ->groupBy('periodo')
                ->orderBy('dataHora ASC');

            $qtdvendas = array();
            $datasvendas = array();

            foreach ($vendas->all() as $key => $v) {
                array_push($qtdvendas, intval($v->total));
                if ($formatdate == 'm') {
                    array_push($datasvendas, Yii::t('app', date('F',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora))));

                } elseif ($formatdate == 'Y') {
                    array_push($datasvendas, date('Y',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora)));

                } else {
                    array_push($datasvendas, date('d/m/Y',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora)));
                }
            }
            
            
            return $this->render('avaliacaoproduto', [
                'qtdvendas' => $qtdvendas,
                'datasvendas' => $datasvendas,
                'datainicio' => ($datainicioavaliacao),
                'datafim' => ($datafimavaliacao),
                'datainicioavaliacao' => date('d/m/Y', strtotime($datainicioavaliacao)),
                'datafimavaliacao' => date('d/m/Y', strtotime($datafimavaliacao)),
                'model' => $model,

            ]);
        } else {
            return $this->render('avaliacaoproduto', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * @param $idProduto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDefinirvalorprodutovenda($idProduto)
    {

        $model = $this->findModel($idProduto);
        if (Yii::$app->request->post()) {
            $porcentagemLucro = (Yii::$app->request->post()['porcentagemLucro']);
            $model->valorVenda =$model->calculoPrecoProduto($idProduto) 
                    +( $model->calculoPrecoProduto($idProduto) * (  $porcentagemLucro /100));
             if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->idProduto]);
             }
        } else {
            return $this->render('definirvalorprodutovenda', [
                'model' => $model,
            ]);
        }
    }

}