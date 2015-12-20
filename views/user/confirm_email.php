<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>

<div class="user-confirm">

    <?php
    if($model === null) {
        ?>
    <div class="alert alert-danger">Не удается найти подтверждение.
        Вы уже подтвердили регистрацию или еще не зареистрировались.
        Для регистрации пройдите по <?php echo Html::a('ссылке', ['user/register']); ?>.
    </div>
        <?php
    }
    else {
        ?>
    <div class="alert alert-success">Вы успешно зарегистрированы в системе и после проверки модератором
        сможете пополнять свои баллы и получать подарки на портале.
    </div>
        <?php
        if( $model->hasErrors() ) {
            echo nl2br(print_r($model->getErrors(), true));
        }
    }
    ?>

</div>
