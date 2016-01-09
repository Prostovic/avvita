<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Электронные письма';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="userorder-index">

<?php
    foreach($files As $k=>$v) {
        echo '<p><strong>'
            . Html::a($v['name'], ['email/get', 'fname' => $v['name']])
            . '</strong> '
            . date('d.m.Y H:i:s', $v['time'])
            . '</p>';
    }
?>


</div>
