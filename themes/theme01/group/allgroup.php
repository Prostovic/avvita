<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\models\User;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $searchGroup app\models\GroupSearch */
/* @var $dataGroup yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;

?>
<!-- div class="good-index row" -->

<?= ListView::widget([
    'dataProvider' => $dataGroup,
    'layout' => "{items}\n{pager}",
    'itemView' => '_group',
    'options' => [
        'class' => "good-index row",
    ],
    'itemOptions' => [
        'class' => "col-sm-6",
    ],
//        'filterModel' => $searchGroup,
]); ?>

<!-- /div -->
