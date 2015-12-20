<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= '' //Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'us_id',
//            'us_active',
            [
                'class' => DataColumn::className(),
                'attribute' => 'us_fam',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) { return $model->userName; },
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'us_email',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) { return $model->us_email . '<br />' . $model->us_phone; },
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'us_group',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) { return $model->groupName; },
                'filter' => User::getGroups(),
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'us_city',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) { return $model->us_city . '<br />' . $model->us_org; },
            ],
//            'us_fam',
//            'us_name',
//            'us_otch',
//            'us_email:email',
//            'us_phone',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {confirm} {testudata}',
                'buttons' => [
                    'confirm' => function ($url, $model, $key) {
                        return $model->us_group == \app\models\User::GROUP_NEWREGISTER ?
                            Html::a('<span class="glyphicon glyphicon-ok"></span>', ['user/confirmemail', 'key' => $model->us_confirmkey], ['title' => 'Подтвердить Email']) :
                            '';
                    },
                    'testudata' => function ($url, $model, $key) {
                        return $model->us_group == \app\models\User::GROUP_CONFIRMED ?
                            Html::a('<span class="glyphicon glyphicon-tag"></span>', ['user/testuserdata', 'id' => $model->us_id], ['title' => 'Проверить данные']) :
                            '';
                    },
                ]
            ],
        ],
    ]); ?>

</div>
