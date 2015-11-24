<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionCreate()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $rule = new \app\rbac\UserGroupRule;
        $auth->add($rule);

        $showGoods = $auth->createPermission('showGoods');
        $showGoods->description = 'Show goods';
        $auth->add($showGoods);

        $confirmUser = $auth->createPermission('confirmUser');
        $confirmUser->description = 'Confirm user data';
        $auth->add($confirmUser);

        $client = $auth->createRole(User::GROUP_CLIENT);
        $client->ruleName = $rule->name;
        $auth->add($client);
        $auth->addChild($client, $showGoods);

        $operator = $auth->createRole(User::GROUP_OPERATOR);
        $operator->ruleName = $rule->name;
        $auth->add($operator);
        $auth->addChild($operator, $confirmUser);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole(User::GROUP_ADMIN);
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $operator);

    }
}
