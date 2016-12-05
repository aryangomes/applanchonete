<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\web\Controller;

class OrcamentoCompra extends Model
{
	public $listaInsumos;
	public $valorTotalCompra;

	//public function rules(){
	//	return [
	//		['listaInsumos', 'requered'],
	//	];
	//}

	public function attributesLabels(){
		return [
			'listaInsumos' => 'Lista de Insumos',
		];
	}

    /**
     * Pega os preços de Produtos
     * @param $ids
     * @return array
     */
	public function pegarPrecoProdutos($ids){
		$arrayPrecos = array();

		//$listaIds = implode(",", $ids);
    	$precos =  Yii::$app->db->createCommand('SELECT idProduto, valorCompra FROM compraproduto')->queryAll();

    	$total_ids = count($ids); 
    	$num_rows = count($precos);

    	for ($i=0; $i < $num_rows; $i++) {
    		for ($j=0; $j < $total_ids; $j++) { 
    			if($precos[$i] == $ids[$j]){
    				$arrayPrecos = $precos[$i];
    			}
    		}
    	}
    	return $arrayPrecos;
	}

}