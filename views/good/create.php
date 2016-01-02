<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Good */

$this->title = 'Добавление подарка';
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
