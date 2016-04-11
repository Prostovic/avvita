<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\web\View;
use app\models\User;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;
/*
$columns = [
    'gd_title',
//    'gd_imagepath',
//    'gd_description:ntext',
    'gd_price',
    'gd_number',
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'ordered',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}' . (Yii::$app->user->can(User::GROUP_CLIENT) ? ' {order}' : ''),
        'buttons' => [
            'order' => function ($url, $model, $key) {
                $options = [
                    'title' => 'Добавить в корзину',
                ];
                return Html::a(
                    '<span class="glyphicon glyphicon-shopping-cart"></span>',
                    ['userorder/append', 'id' => $model->gd_id],
                    $options
                );
            },
        ],
    ],
];
*/
?>
<!-- div class="good-index row" -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'itemView' => '_good',
        'options' => [
//            'tag' => '',
//            'class' => "good-index row",
        ],
        'itemOptions' => [
//            'class' => "col-sm-6",
            'tag' => false,
        ],
//        'filterModel' => $searchModel,
    ]); ?>

<?php

$sJs = <<<EOT
jQuery(".single-post-title h2").each(function(index, el){
    var ob = jQuery(this),
        nCur = ob.height();
    if( nCur > 54 ) {
        ob
            .height(54)
            .hover(function(event){ ob.height(nCur); }, function(event){ ob.height(54); });
    }
});

EOT;

$this->registerJs($sJs, View::POS_READY);

?>
<!-- /div -->
