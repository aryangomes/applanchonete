<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    'css/site.css',
    'admin/bootstrap.css',
    'admin/sb-admin.css',
    'admin/plugins/morris.css',
    //'admin/metisMenu.css',
    //'admin/font-awesome.min.css',
    'admin/font-awesome/css/font-awesome.min.css',
    ];
    public $js = [
   // 'admin/js/bootstrap.js',
   // 'admin/js/form-insumo.js'
    ];
    public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    ];


}
