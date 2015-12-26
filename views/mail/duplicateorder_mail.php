<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 09.11.2015
 * Time: 0:17
 */

//use yii;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $data app\models\Userdata */

$aLink = ['userdata/index', 'UserdataSearch[ud_doc_key]' => $data->ud_doc_key];

?>

<p>Здравствуйте, <?= Html::encode($model->getUserName(true)) ?>.</p>

<p>На сайте <?= Yii::$app->name ?> пользователь <?php echo Html::encode($data->user->getUserName()) ?>
    повторно зарегистрирован заказ <?php echo Html::encode($data->ud_doc_key); ?>.</p>

<p>Вы можете посмотреть данные по заказу: <?= Html::a(Url::to($aLink, true), Url::to($aLink, true)) ?></p>
