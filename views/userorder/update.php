<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */

$this->title = 'Update Userorder: ' . ' ' . $model->ord_id;
$this->params['breadcrumbs'][] = ['label' => 'Userorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ord_id, 'url' => ['view', 'id' => $model->ord_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userorder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
