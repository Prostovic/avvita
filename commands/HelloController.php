<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;
use app\components\Notificator;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        $model = new User();
        $model->us_email = '452@list.ru';
        $model->us_fam = 'Fam';
        $model->us_name = 'Name';
        $model->us_otch = 'Otch';

        $oNotify = new Notificator([$model], $model, 'activate_mail');
        $oNotify->notifyMail('Вы проверены на портале "' . Yii::$app->name . '"');

//        Yii::$app->mailer->compose()
//            ->setFrom(Yii::$app->mailer->username)
//            ->setTo('452@list.ru')
//            ->setSubject('Email sent from Yii2-Swiftmailer')
//            ->send();
        echo $message . "\n";
    }
}
