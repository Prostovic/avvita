<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\web\View;

use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;

use app\assets\Theme01Asset;
use app\models\User;

Theme01Asset::register($this);

$sJs = <<<EOT
var fSetNavbar = function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
};

$(window).scroll(fSetNavbar);
fSetNavbar();

EOT;

$this->registerJs($sJs, View::POS_READY);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <?php
    $sMenuName = 'guest';
    if( !Yii::$app->user->isGuest ) {
        if( Yii::$app->user->can(User::GROUP_ADMIN) || Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            $sMenuName = 'operator';
        }
        elseif( Yii::$app->user->can(User::GROUP_CLIENT) ) {
            $sMenuName = 'client';
        }
    }

    echo $this->render('//layouts/' . $sMenuName . '_menu', []);

    if( Yii::$app->defaultRoute != Yii::$app->controller->getRoute() ) {
        ?>
        <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><?= Html::encode($this->title) ?></h1>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
    else {
        $aCarousel = [
            [
                'title' => 'Смотрим сюда',
                'text' => 'Тут можно сделать так',
            ],
            [
                'title' => 'Здесь новинки',
                'text' => 'Такого еще никогда не было',
            ],
            [
                'title' => 'А тут есть линзы',
                'text' => 'Это гланое направление',
            ],
        ];
        foreach($aCarousel As $k=>$v) {
            $aCarousel[$k]['html'] = Html::tag(
                'div',
                Html::tag(
                    'div',
                    Html::tag(
                        'div',
                        Html::tag(
                            'div',
                            Html::tag(
                                'h2',
                                Html::encode($v['title']),
                                ['class' => 'animation animated-item-1']
                            )
                            . Html::tag(
                                'p',
                                Html::encode($v['text']),
                                ['class' => 'animation animated-item-2']
                            ),
                            ['class' => 'carousel-content centered']
                        ),
                        ['class' => 'col-sm-12']
                    ),
                    ['class' => 'row']
                ),
                ['class' => 'container']
            );
        }
/*
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="carousel-content centered">
                <h2 class="animation animated-item-1">Welcome to BASICA! A Bootstrap3 Template</h2>
                <p class="animation animated-item-2">Sed mattis enim in nulla blandit tincidunt. Phasellus vel sem convallis, mattis est id, interdum augue. Integer luctus massa in arcu euismod venenatis. </p>
            </div>
        </div>
    </div>
</div>
*/
        $sDop = substr(Yii::getAlias('@webroot'), strlen($_SERVER['DOCUMENT_ROOT']));
        echo '<section id="main-slider" class="no-margin">';
        echo Carousel::widget([
            'controls' => [
                Html::tag('i', '', ['class' => 'fa fa-angle-left']),
                Html::tag('i', '', ['class' => 'fa fa-angle-right']),
            ],
            'items' => [
            // the item contains only the image
//                '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-01.jpg"/>',
                // equivalent to the above
                [
                    'content' => $aCarousel[0]['html'], // '<img src="/theme01/carousel-01.jpg"/>',
                    'options' => ['style' => 'background-image: url('.$sDop.'/theme01/top-07.jpg)'],
                ],
                [
                    'content' => $aCarousel[1]['html'], // '<img src="/theme01/carousel-01.jpg"/>',
                    'options' => ['style' => 'background-image: url('.$sDop.'/theme01/top-10.jpg)'],
                ],
                [
                    'content' => $aCarousel[2]['html'], // '<img src="/theme01/carousel-01.jpg"/>',
                    'options' => ['style' => 'background-image: url('.$sDop.'/theme01/top-03.jpg)'],
                ],
                // the item contains both the image and the caption
//                [
//                    'content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-03.jpg"/>',
//                    'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
//                    'options' => [],
//                ],
            ]
        ]);
        echo '</section>';
//    echo '<p>' . Yii::$app->defaultRoute . ' == ' . Yii::$app->controller->getRoute() . '</p>';
/*
        <section class="no-margin" id="main-slider">
            <div class="carousel slide">
                <div class="carousel-inner">
                    <div style="background-image: url(img/slides/1.jpg)" class="item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="carousel-content centered">
                                        <h2 class="animation animated-item-1">Welcome to BASICA! A Bootstrap3 Template</h2>
                                        <p class="animation animated-item-2">Sed mattis enim in nulla blandit tincidunt. Phasellus vel sem convallis, mattis est id, interdum augue. Integer luctus massa in arcu euismod venenatis. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>

*/
    }
?>
<div class="section">
    <div class="container">
        <?= '' /* Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])*/ ?>
        <?php
            $aMsg = ['danger', 'success', 'info', 'warning', ];
            foreach($aMsg As $v) {
                if( Yii::$app->session->hasFlash($v) ) {
                    echo '<div class="alert alert-'.$v.'" role="alert">'.Html::encode(Yii::$app->session->getFlash($v)).'</div>';
                }
            }
//
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-footer col-md-4 col-xs-6">
                <h3>Контакты</h3>
                <p class="contact-us-details">
                    <b>Адрес:</b> 107564, Москва, ул. Краснобогатырская, д.2, стр. 3<br>
                    <b>Телефон:</b> <a href="tel:+74959336291">+7 (495) 933-62-91</a> <br>
                    <b>Email:</b> <a href="mailto:info@avvita.ru">info@avvita.ru</a>
                </p>
            </div>
            <div class="col-footer col-md-4 col-xs-6">
                <h3>Наши ресурсы</h3>
                <p class="contact-us-details">
                    <b>Сайт:</b> <a href="http://www.avvita.ru/">www.avvita.ru</a><br>
                </p>
            </div>
            <div class="col-footer col-md-4 col-xs-6">
                <h3>О компании</h3>
                <p>Оптовая компания « АВВИТА» - крупный российский импортер очковой оптики. Портфель компании представлен широким ассортиментом медицинских оправ, спортивных и солнцезащитных очков производства мировых лидеров оптической индустрии, очковых линз концерна Rodenstock.</p>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="footer-copyright">
                    &copy; <?= Yii::$app->name ?> <?= date('Y') ?>
                    <!-- p class="pull-left">&copy; <?= '' // Yii::$app->name ?> <?= '' // date('Y') ?></p -->
                </div>
            </div>
        </div>
        <!-- p class="pull-right"><?= '' // Yii::powered() ?></p -->
    </div>
</footer>

<?php
// Окно для сообщения
Modal::begin([
'header' => '<span></span>',
'id' => 'messagemodaldata',
'size' => Modal::SIZE_LARGE,
]);
Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
