<?php

use yii\helpers\Html;
use yii\web\View;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Banner;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;

$jJs = <<<EOT
jQuery(".grigajaxlink").on(
    "click",
    function(event) {
        event.preventDefault();
        var href = jQuery(this).attr("href");
        jQuery.getJSON(
            href,
            function(data) {
                window.location.reload();
            }
        );
        return false;
    }
);
EOT;

$this->registerJs($jJs, View::POS_READY);

?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'bnr_id',
//            'bnr_active',
//            'bnr_imagepath',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'bnr_imagepath',
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var $model app\models\Banner */
                    return '<div style="float: left; margin: 0 10px 10px 0; border: 1px solid #666666; width: 180px;">'
                        . Html::img(str_replace('\\', '/', $model->bnr_imagepath), ['alt' => $model->bnr_title, 'style' => 'width: 100%;'])
                        . '</div>'
                        . '<a href="/banner/changevisible/' . $model->bnr_id . '" class="grigajaxlink" title="' . ($model->bnr_active ? 'скрыть' : 'показать') . ' изображение">'
                        . '<span class="glyphicon glyphicon-' . ($model->bnr_active ? 'ok' : 'remove') . ' right-glyth"></span>'
                        . '</a>';
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'bnr_group',
                'filter' => ArrayHelper::map(Banner::getAllGroups(), 'bnr_group', 'bnr_group'),
            ],
//            'bnr_group',
            'bnr_title',
            'bnr_description:ntext',
            // 'bnr_created',
            // 'bnr_order',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
