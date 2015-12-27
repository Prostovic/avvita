<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Goodimg */

$this->title = 'Update Goodimg: ' . ' ' . $model->gi_id;
$this->params['breadcrumbs'][] = ['label' => 'Goodimgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gi_id, 'url' => ['view', 'id' => $model->gi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goodimg-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
