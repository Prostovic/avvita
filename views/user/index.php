<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'us_id',
            'us_active',
            'us_fam',
            'us_name',
            'us_otch',
            // 'us_email:email',
            // 'us_phone',
            // 'us_adr_post',
            // 'us_birth',
            // 'us_pass',
            // 'us_position',
            // 'us_city',
            // 'us_org',
            // 'us_city_id',
            // 'us_org_id',
            // 'us_created',
            // 'us_confirm',
            // 'us_activate',
            // 'us_getnews',
            // 'us_getstate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
