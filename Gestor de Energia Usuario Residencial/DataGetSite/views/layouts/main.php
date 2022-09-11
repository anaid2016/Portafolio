<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        
        
        $perfil = (!empty(Yii::$app->user->identity->perfil_id))? Yii::$app->user->identity->perfil_id:'';
        $menuItems = array();
        $menuver = array();
        NavBar::begin([
            'brandLabel' => 'SGE',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        
        
        
        if (!Yii::$app->user->isGuest and $perfil == 1) {
            $menuver = [
                '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->nombre_usuario . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ];
            $menuItems = [
                [
                    'label' => 'Administración', 'vista' => false,
                    'items' => [
                        ['label' => 'Proyectos', 'url' => ['/sgeproyectos'], 'vista' => false],
                        ['label' => 'Concentradores', 'url' => ['/sgeconcentradores'], 'vista' => false],
                        ['label' => 'Circuitos', 'url' => ['/sgecircuitos'], 'vista' => false],
                        ['label' => 'Medidores', 'url' => ['/sgemedidores'], 'vista' => false],
                    ]
                ],
                [
                    'label' => 'Consulta', 'vista' => false,
                    'items' => [
                        ['label' => 'Datos', 'url' => ['/sgelecturas'], 'vista' => false],
                        ['label' => 'Graficas', 'url' => ['/sgelecturas/graficas'], 'vista' => false],
                    ]
                ],
                '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->nombre_usuario . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ];
        }else if(!Yii::$app->user->isGuest and $perfil == 2){
            
            
            $menuver = [
                '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->nombre_usuario . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ];
            $menuItems = [
                [
                    'label' => 'Consulta', 'vista' => false,
                    'items' => [
                        ['label' => 'Datos', 'url' => ['/sgelecturas'], 'vista' => false],
                        ['label' => 'Graficas', 'url' => ['/sgelecturas/graficas'], 'vista' => false],
                    ]
                ],
                '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->nombre_usuario . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ];
            
            
        }else {
            $menuItems = [['label' => 'Login', 'url' => ['/site/login']]];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItems
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= $content ?>
        </div>
    </main>
    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; WMSAS <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <!-------------------------------------------------------------------PARA LAS ALERTAS -------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------------------------------------------------------->
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $message) :
        if (!empty($message['type'])) {
            if ($message['type'] == 'success') {

                if (empty($message['message2'])) {
                    $message['message2'] = '';
                }

                $this->registerJs('$("document").ready(function(){ swal({
                                        title: "' . $message['message'] . '",
                                        text: "' . $message['message2'] . '",    
                                        type: "success",
                                        showCancelButton: false,
                                        closeOnConfirm: true,
                                        allowOutsideClick: true,
                                    }, function(isConfirm){
                                            if (isConfirm) {
                                                    swal.close()
                                            } else {
                                            }
                                    }); });');
            } else if ($message['type'] == 'url') {

                $_value = yii\helpers\Url::toRoute([
                    $message['urlgo'],
                    'var1' => $message['var1'],
                    'var2' => $message['var2'],
                    'var3' => $message['var3']
                ], true);

                $this->registerJs('$("document").ready(function(){ swal({
                                                    title: "' . $message['message'] . '",
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    closeOnConfirm: true,
                                                    allowOutsideClick: true,
                                            }, function(isConfirm){
                                                if (isConfirm) {
                                                    eventClick("' . $_value . '","' . $message['message2'] . '");
                                                } else {
                                                    swal.close();
                                                }
                                            }); });');
            } else if ($message['type'] == 'error') {

                $this->registerJs('$("document").ready(function(){ swal({
                                                title: "' . $message['message'] . '",
                                                text: "' . $message['message2'] . '",
                                                type: "warning",
                                                showCancelButton: false,
                                                closeOnConfirm: true,
                                                allowOutsideClick: true,
                                            }, function(isConfirm){
                                                if (isConfirm) {
                                                        swal.close()
                                                } else {
                                                }
                                            }); });');
            }
        } else {
            Alert::widget();
        }
    endforeach;
    /*-----------------------------------------FIN CAMPO ALERTAS -------------*/


    ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>





<!------------------------------------------------------------------------------------------>
<!--ACTIVA LA VENTANA MODAL PARA LOS FORMULARIOS-------------------------------------------->
<!------------------------------------------------------------------------------------------>
<?php
yii\bootstrap\Modal::begin([
    'header' =>  '',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>