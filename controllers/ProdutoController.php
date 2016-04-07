<?php

namespace app\controllers;

use Yii;
use app\models\Produto;
use app\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Categoria;
use app\models\Itempedido;
use yii\helpers\ArrayHelper;
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

    /**
     * Displays a single Produto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
    }

    public function actionListadeinsumos()
    {
        $model = new Produto();
        $produtosVenda = ArrayHelper::map(
            Produto::find()->join('INNER JOIN','insumos', 'idProduto = idprodutoVenda ')
            ->where(['isInsumo'=>0 ])->all(), 
            'idProduto','nome');
        if ((Yii::$app->request->post())) {
           $searchModel = new ProdutoSearch();

           $listadeinsumos = $searchModel->searchInsumos(Yii::$app->request->post());

           $insumos = array();

           foreach ($listadeinsumos as  $insumo) {
            array_push($insumos, 
                $model::findOne($insumo->idprodutoInsumo));
        }

        return $this->render('listadeinsumos', [
            'insumos' => $insumos,
            'produtosVenda' => $produtosVenda,  
            ]); 
    } else {

        return $this->render('listadeinsumos', [
            'produtosVenda' => $produtosVenda,

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
        $categorias = ArrayHelper::map(
            Categoria::find()->all(), 
            'idCategoria','nome');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProduto]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'categorias' => $categorias,
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
        $categorias = ArrayHelper::map(
            Categoria::find()->all(), 
            'idCategoria','nome');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProduto]);
        } else {
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

    public function actionAvaliacaoproduto($idproduto) 
    { 
      $model = $this->findModel($idproduto); 
      if (Yii::$app->request->post()) {
       // var_dump(Yii::$app->request->post());
        $groupbyavaliacao = Yii::$app->request->post()['Produto']['groupbyavaliacao'];
        $datainicioavaliacao = Yii::$app->request->post()['Produto']['datainicioavaliacao'];
        $datafimavaliacao = Yii::$app->request->post()['Produto']['datafimavaliacao'];

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

    /*    $vendas =
        Itempedido::find()
        ->join('INNER JOIN','produto','produto.idProduto = itempedido.idProduto')
        ->join('INNER JOIN','pedido','pedido.idPedido = itempedido.idPedido')
        ->join('INNER JOIN','comanda','comanda.idComanda = pedido.idPedido')
        ->groupBy('dataHoraFechamento')

      //->where(['idProduto'=>$idproduto])
        ->all();

        $vendas = Itempedido::findBySql('
            select * from (((produto natural join itempedido)
                natural join pedido) natural join comanda) GROUP BY dataHoraFechamento;
        ')->all();


select sum(quantidade),nome,dataHoraFechamento from (((produto natural join itempedido)
            natural join pedido) natural join comanda)
WHERE  MONTH(dataHoraFechamento) = 4
GROUP BY DAY(dataHoraFechamento) 
ORDER BY `comanda`.`dataHoraFechamento` DESC


-----------------------

select sum(quantidade),nome,dataHoraFechamento from (((produto natural join itempedido)
            natural join pedido) natural join comanda)
WHERE  (dataHoraFechamento) >= ('01-04-2016') and (dataHoraFechamento) <=  ('30-04-2016') 
GROUP BY MONTH(dataHoraFechamento) 
ORDER BY `comanda`.`dataHoraFechamento` DESC
*/

$vendas =
Itempedido::find('MONTH(dataHoraFechamento)')
->joinWith('produtos')
->joinWith('pedidos')
->joinWith('pedidos.comandas')
//->where(['produto.idProduto'=>$idproduto])
//->where( ['between', 'dataHoraFechamento', $datainicioavaliacao, $datafimavaliacao])
->andFilterWhere(['=','produto.idProduto',$idproduto])
->andFilterWhere(['<=','dataHoraFechamento',$datafimavaliacao])
/*->andFilterWhere(['>=','dataHoraFechamento',$datainicioavaliacao])
->andFilterWhere(['<=','dataHoraFechamento',$datafimavaliacao])*/
->groupBy($groupbyavaliacao.'(dataHoraFechamento)');

//var_dump($vendas->sum('quantidade'));$quantidade = $vendas->sum('quantidade');
$vendas = Itempedido::find();

$vendas
->select( '*, sum(quantidade) as total, '.$groupbyavaliacao.'(dataHoraFechamento) as periodo')
->joinWith('produtos')
->joinWith('pedidos')
->joinWith('pedidos.comandas')
->andFilterWhere([
    'produto.idProduto' => $idproduto,

    ])
->andFilterWhere(['>=','dataHoraFechamento',$datainicioavaliacao])
->andFilterWhere(['<=','dataHoraFechamento',$datafimavaliacao])
->groupBy('periodo');


$a1 = array();
$a2 = array();
foreach ($vendas->all() as $key => $v) {
  //  var_dump($vendas[0]->sum('quantidade'));
    //echo $v->quantidade .' - ' .  ($v->pedidos->comandas->dataHoraFechamento) .'</br>';
    array_push($a1, intval($v->total));
    array_push($a2, date('d/m/Y',strtotime($v->pedidos->comandas->dataHoraFechamento)));

}


     //;
     // var_dump($vendas[1]->pedidos['comandas']->dataHoraFechamento);
     // $v1 = $vendas->sum('quantidade');
return $this->render('avaliacaoproduto', [
    'a1'=>$a1,
    'a2'=>$a2,
    'model'=>$model,
    ]);
}
else{
    return $this->render('avaliacaoproduto', [
        'model'=>$model,
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
}