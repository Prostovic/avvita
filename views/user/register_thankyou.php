<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Благодарим за регистрацию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-register_thankyou">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::encode($model->getUserName(true)) ?>, Вы зарегистрировались на портале <?= Html::encode(Yii::$app->name) ?></p>
    <p>На Ваш email <?= Html::encode($model->us_email) ?> отправлено письмо с ссылкой для подтверждения адреса электронной почты.</p>
    <p>Пройдите по этой ссылке, чтобы получить возможность взаимодействовать с данным сайтом.</p>

    <?php
    if( Yii::$app->mailer->useFileTransport ) {
        echo '<p>Поскольку письма не отправляются, ниже приводится сождержимое отправленного письма в формате электронной почты. Вы можете сохранить текст в файл и открыть его клиентом электронной почты.</p>';
        $sDir = Yii::getAlias(Yii::$app->mailer->fileTransportPath);
        $tDel = time() - 4 * 24 - 3600; // старее 4 дней - удаляем
        $tMax = null;
        $sfLast = null;

        if( $hd = opendir($sDir) ) {
            while( false !== ($f = readdir($hd)) ) {
                if( ($f == '.') || ($f == '..') ) {
                    continue;
                }
                $sf = $sDir . DIRECTORY_SEPARATOR . $f;
                $t = filemtime($sf);
                if( $t < $tDel ) {
//                    echo '<p>Del old file: '.$sf.' '.date('d.m.Y H:i:s', $t).'</p>';
                    unlink($sf);
                    continue;
                }
                if( $tMax === null ) {
                    $tMax = $t;
                    $sfLast = $sf;
//                    echo '<p>First file: '.$sf.' '.date('d.m.Y H:i:s', $t).'</p>';
                }
                else if( $tMax < $t ) {
                    $tMax = $t;
                    $sfLast = $sf;
//                    echo '<p>New First file: '.$sf.' '.date('d.m.Y H:i:s', $t).'</p>';
                }
            }
            closedir($hd);
        }

        if( $sfLast !== null ) {
            echo '<div style="border: 1px solid #000000; padding: 12px; background-color: #eeeeee; color: #000000;">'
                . nl2br(file_get_contents($sfLast))
                . '</div>';
        }
    }
    ?>

</div>
