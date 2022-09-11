<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CgmUsuario */

$this->title = 'Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cgm-usuario-create">

    <?= $this->render('_form', [
        'model' => $model,'perfiles'=>$perfiles
    ]) ?>

</div>
