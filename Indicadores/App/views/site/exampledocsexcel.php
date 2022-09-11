
<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\widgets;

$this->title = 'Example';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">	
<section class="site-about">
    
    <div class="container">
        <?= widgets\HtmltoExcel::widget(['htmlContent' => $htmlContent,'namefile'=>'ejemplo2']) ?>
    </div>
</section>
</div>