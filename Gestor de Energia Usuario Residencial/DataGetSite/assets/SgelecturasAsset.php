<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue 
 * @since 2.0
 */
class SgelecturasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
      'js/sgelecturas/graficas.js?v1.1',
    ];
    public $depends = [
            'yii\web\YiiAsset',
            // 'yii\bootstrap\BootstrapAsset',
            '\yii\web\JqueryAsset',
        ];
}
