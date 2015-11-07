<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
$data = [
    'backCreateUser' => [
        'title' => $model->isNewRecord ? 'Добавление оператора' : 'Изменение оператора',
        'form' => '_form',
    ],
    'register' => [
        'title' => $model->isNewRecord ? 'Регистрация пользователя' : 'Изменение пользователя',
        'form' => '_formreg',
    ],
//    '' => $model->isNewRecord ? '' : '',
];
$this->title = isset($data[$model->scenario]) ? $data[$model->scenario]['title'] : $model->scenario;
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->us_id, 'url' => ['view', 'id' => $model->us_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render(
        isset($data[$model->scenario]) ? $data[$model->scenario]['form'] : '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>
