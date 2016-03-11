<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = 'Новая группа';
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <div class="col-xs-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
