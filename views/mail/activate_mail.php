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

$aLink = ['user/confirmemail', 'key' => $model->us_confirmkey];

/* <?= Html::encode(Yii::$app->name) ?> */
// , а также ознакомительную презентацию – шпаргалку.
// http://ask.educom.ru/respondent/index.php
?>

<p>Здравствуйте, <?= Html::encode($model->getUserName(true)) ?>.</p>

<p>Ваши данные на сайте <?= Yii::$app->name ?> проверены администратором.</p>

<p>Вы можете начать пользоваться сайтом: вводить Ваши заказы и получать подарки в соответствии с Вашими бонусами.</p>

