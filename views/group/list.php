<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Group;
use app\models\Good;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $nMinOrder integer */
/* @var $nMaxOrder integer */

$this->title = 'Группы подарков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить группу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'grp_id',
//            'grp_title',
//            [
//                'class' => 'yii\grid\DataColumn',
//                'attribute' => 'grp_title',
////                'filter' => false,
//                'format' => 'raw',
//                'value' => function ($model, $key, $index, $column) {
//                    /** @var $model app\models\Group */
//                    return '<span class="glyphicon glyphicon-'.($model->grp_active ? 'ok' : 'remove').' right-glyth"></span>' . Html::encode($model->grp_title);
//                },
//            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'grp_imagepath',
                'filter' => false,
                'header' => 'Группа',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var $model app\models\Group */
                    $nCou = count($model->goods);
                    $sGoods = $nCou > 0 ?
                        ( ' <!-- ['
                            . $nCou
                            . '] -->:<br />'
                            . implode('<br />', ArrayHelper::map(
                                $model->goods,
                                'gd_id',
                                function($element){
                                    /** @var Good $element */
                                    return Html::encode($element->gd_title);
                                }
                            ))
                        ):
                        '';
                    return Html::img($model->grp_imagepath, ['alt' => $model->grp_title, 'style' => 'float: left; margin: 0 10px 10px 0; border: 1px solid #666666;'])
                        . '<span class="glyphicon glyphicon-'.($model->grp_active ? 'ok' : 'remove') . ' right-glyth"></span>'
                        . '<strong>' . Html::encode($model->grp_title) . '</strong>'
                        . $sGoods;
                },
            ],
//            'grp_imagepath',
//            'grp_description:ntext',
//            'grp_active',
            // 'grp_created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {up} {down}',
                'buttons' => [
                    'up' => function ($url, $model, $key) use($nMinOrder) {
                        /** @var Group $model */
                        return $model->grp_order == $nMinOrder ?
                            '' :
                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, []);
                    },
                    'down' => function ($url, $model, $key) use ($nMaxOrder) {
                        /** @var Group $model */
                        return $model->grp_order == $nMaxOrder ?
                            '' :
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, []);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
