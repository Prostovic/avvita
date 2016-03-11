<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Goodgroup */

$this->title = 'Create Goodgroup';
$this->params['breadcrumbs'][] = ['label' => 'Goodgroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodgroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
