<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->us_id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->us_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->us_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'us_id',
            'us_active',
            'us_fam',
            'us_name',
            'us_otch',
            'us_email:email',
            'us_phone',
            'us_adr_post',
            'us_birth',
            'us_pass',
            'us_position',
            'us_city',
            'us_org',
            'us_city_id',
            'us_org_id',
            'us_created',
            'us_confirm',
            'us_activate',
            'us_getnews',
            'us_getstate',
        ],
    ]) ?>

</div>
