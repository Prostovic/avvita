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

$aLink = ['user/restorepass', 'key' => $model->us_op_key];

/* <?= Html::encode(Yii::$app->name) ?> */
// , а также ознакомительную презентацию – шпаргалку.
// http://ask.educom.ru/respondent/index.php
?>

<p>Здравствуйте, <?= Html::encode($model->getUserName(true)) ?>.</p>

<p>На сайте <?= Url::home(true) ?> кто-то ввел данный email в форме для восстановления пароля.</p>

<p>Если это были не Вы, проигнорируйте данное письмо.</p>

<p>Для ввода нового пароля перейдите по ссылке: <?= Html::a(Url::to($aLink, true), Url::to($aLink, true)) ?></p>

