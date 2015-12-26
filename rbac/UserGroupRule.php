<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 22.11.2015
 * Time: 12:54
 */

namespace app\rbac;

use yii;
use yii\rbac\Rule;
use app\models\User;

class UserGroupRule extends Rule {

    public $name = 'userGroup';

    public function execute($user, $item, $params) {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->us_group;
            Yii::info('execute() user = ' . print_r($user, true) . "\nitem = " . print_r($item, true) . "\nparams = " . print_r($params, true));
            if( $item->name === User::GROUP_ADMIN ) {
                return $group == User::GROUP_ADMIN;
            }
            elseif( $item->name === User::GROUP_OPERATOR ) {
                return $group == User::GROUP_ADMIN || $group == User::GROUP_OPERATOR;
            }
            elseif( $item->name === User::GROUP_CLIENT ) {
                return $group == User::GROUP_CLIENT;
            }
        }
        return false;
    }

}