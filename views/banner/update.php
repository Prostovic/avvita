<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = $model->isNewRecord ? 'Создание банера' : 'Изменение банера';
$this->params['breadcrumbs'][] = ['label' => 'Изображения', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->bnr_id, 'url' => ['view', 'id' => $model->bnr_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-update">

    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
