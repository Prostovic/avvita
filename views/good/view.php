<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Good */

$this->title = $model->gd_title;
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => [Yii::$app->user->can(User::GROUP_OPERATOR) ? 'list' : 'index']];
$this->params['breadcrumbs'][] = $this->title;

/*
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gd_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gd_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
 */
$attributes = [
//            'gd_id',
            'gd_title',
//            'gd_imagepath',
            'gd_description:ntext',
            'gd_price',
            'gd_number',
//            'gd_active',
        ];
if( Yii::$app->user->can(User::GROUP_OPERATOR) ) {
    $attributes[] = 'gd_created';
}
?>
<div class="good-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

    <?php if( Yii::$app->user->can(User::GROUP_CLIENT) ) { ?>
        <p>
            <?php echo Html::a('В корзину', ['userorder/append', 'goodid' => $model->gd_id], ['class' => 'btn btn-success', 'title' => 'Добавить в корзину']); ?>
        </p>
    <?php } ?>

</div>
