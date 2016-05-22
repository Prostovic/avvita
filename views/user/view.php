<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->us_fam . ' ' . $model->us_name . ' ' . $model->us_otch;

$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$oCity = $model->city;
$oOrg = $model->org;

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- p>
        <?= '' // Html::a('Update', ['update', 'id' => $model->us_id], ['class' => 'btn btn-primary']) ?>
        <?= '' /* Html::a('Delete', ['delete', 'id' => $model->us_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'us_id',
//            'us_active',
            'us_fam',
            'us_name',
            'us_otch',
            'us_email:email',
            'us_phone',
            'us_adr_post',
            'us_birth',
//            'us_pass',
//            'us_position',
            [
                'attribute' => 'us_position',
                'value' => $model->getPosition(),
            ],
//            'us_city',
//            'us_org',
//            'us_city_id',
            [
                'attribute' => 'us_city_id',
                'value' => $oCity === null ? $model->us_city : ($oCity->city_name . ' ('.$model->us_city.')'),
            ],
//            'us_org_id',
            [
                'attribute' => 'us_org_id',
                'value' => $oOrg === null ? $model->us_org : ($oOrg->org_name . ' ('.$model->us_org.')'),
            ],
            'us_created',
            'us_confirm',
            'us_activate',
            'us_getnews',
            'us_getstate',
        ],
    ]) ?>

</div>
