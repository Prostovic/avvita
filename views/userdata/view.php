<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Docdata;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */

$bDop = (count($model->docs) == 1) && ($model->docs[0]->doc_org_id == -1);
$this->title = 'Состав заказа ' . ($bDop ? $model->docs[0]->doc_title : $model->ud_doc_key);
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/*
    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ud_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ud_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

*/
if( count($model->docs) > 0 ) {
    /** @var Docdata $ob */
    $aLabel = $model->docs[0]->attributeLabels();
    $sItems = '<table class="table table-bordered">';
    $sItems .= '<tr><th>'
        . $aLabel['doc_date']
        . '</th><th>'
        . $aLabel['doc_title']
        . '</th><th>'
        . $aLabel['doc_fullordernum']
        . '</th><th>'
        . $aLabel['doc_ordernum']
        . '</th><th>'
        . $aLabel['doc_summ']
        . '</th></tr>';
    $sItems .= array_reduce(
        $model->docs,
        function($res, $item) use($bDop) {
            /** @var Docdata $item */
            return $res
            . '<tr><td>'
            . date('d.m.Y', strtotime($item->doc_date))
            . '</td><td>'
            . $item->doc_title
            . '</td><td>'
            . ($bDop ? '' : $item->doc_fullordernum)
            . '</td><td>'
            . ($bDop ? '' : $item->doc_ordernum)
            . '</td><td>'
            . $item->doc_summ
            . '</td></tr>'
            . "\n";
        },
        ''
    );
    $sItems .= '</table>';
}

?>
<div class="userdata-view">
    <?= $sItems ?>
    <?= '' /* DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'ud_id',
//            'ud_doc_id',
//            'ud_us_id',
            'ud_doc_key',
            [
                'attribute' => 'docs',
                'format' => 'raw',
                'value' => $sItems,
            ],

//            'ud_created',
        ],
    ])*/ ?>

</div>
