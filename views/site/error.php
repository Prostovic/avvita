<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;

$isMailException = strpos(strtolower(get_class($exception)), 'swift_') !== false;
/*
<p>
Код ошибки <?= $exception->getCode() . ' ' . get_class($exception) ?>.
</p>
*/

?>
<div class="site-error">

    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message . ' [' . $name . ']')) ?>
    </div>

    <p>
        Ошибка возникла в процессе обработки запроса веб сервером.
    </p>
    <p>
        Мы постараемся исправить ошибку в ближайшее время.
    </p>

</div>
