<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Docdata */

$this->title = 'Create Docdata';
$this->params['breadcrumbs'][] = ['label' => 'Docdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
