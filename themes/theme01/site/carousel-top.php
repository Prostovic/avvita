<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Carousel;

/* @var $data array */

$aData = ArrayHelper::map(
    $data,
    'bnr_id',
    function($el) {
        /** @var app\models\Banner $el  */
        return [
            'content' => Html::tag(
                'div',
                Html::tag(
                    'div',
                    Html::tag(
                        'div',
                        Html::tag(
                            'div',
                            Html::tag(
                                'h2',
                                Html::encode($el->bnr_title),
                                ['class' => 'animation animated-item-1']
                            )
                            . Html::tag(
                                'p',
                                Html::encode($el->bnr_description),
                                ['class' => 'animation animated-item-2']
                            ),
                            ['class' => 'carousel-content centered']
                        ),
                        ['class' => 'col-sm-12']
                    ),
                    ['class' => 'row']
                ),
                ['class' => 'container']
            ),
            'options' => ['style' => 'background-image: url('.str_replace('\\', '/', $el->bnr_imagepath).')'],
        ];
    }
);

echo '<section id="main-slider" class="no-margin">';
echo Carousel::widget([
    'controls' => [
        Html::tag('i', '', ['class' => 'fa fa-angle-left']),
        Html::tag('i', '', ['class' => 'fa fa-angle-right']),
    ],
    'items' => array_values($aData),
]);
echo '</section>';

// echo 'carousel-top ' . count($data);