<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Orderitem */

$this->title = 'Update Orderitem: ' . ' ' . $model->ordit_id;
$this->params['breadcrumbs'][] = ['label' => 'Orderitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ordit_id, 'url' => ['view', 'id' => $model->ordit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orderitem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
