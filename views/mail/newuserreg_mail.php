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
/* @var $data app\models\User */

$aLink = ['user/testuserdata', 'id' => $data->us_id];

?>

<p>Здравствуйте, <?= Html::encode($model->getUserName(true)) ?>.</p>

<p>На сайте <?= Yii::$app->name ?> зарегистрировался новый пользователь.</p>

<p>Вы можете проверить его данные: <?= Html::a(Url::to($aLink, true), Url::to($aLink, true)) ?></p>

