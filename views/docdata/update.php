<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Docdata */

$this->title = 'Update Docdata: ' . ' ' . $model->doc_id;
$this->params['breadcrumbs'][] = ['label' => 'Docdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->doc_id, 'url' => ['view', 'id' => $model->doc_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docdata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
