<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = 'Update Group: ' . ' ' . $model->grp_id;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->grp_id, 'url' => ['view', 'id' => $model->grp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
