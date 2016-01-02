<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */

// $this->title = 'Update Userorder: ' . ' ' . $model->ord_id;
$this->title = 'Изменение заказа'; //  . ' ' . $model->gd_id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => [Yii::$app->user->can(User::GROUP_OPERATOR) ? 'index' : 'list']];
// $this->params['breadcrumbs'][] = ['label' => $model->ord_id, 'url' => ['view', 'id' => $model->ord_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userorder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
