<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 20.12.2015
 * Time: 21:39
 */

namespace app\components;
use yii\validators\Validator;


class CapitalizeFilter extends Validator {

    public function init() {
        parent::init();
        $this->message = 'Invalid status input.';
    }

    public function validateAttribute($model, $attribute) {
        $sEncode = 'UTF-8';
        mb_internal_encoding($sEncode);
        $value = $model->$attribute;
        $model->$attribute = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    public function clientValidateAttribute($model, $attribute, $view) {
//        $statuses = json_encode(Status::find()->select('id')->asArray()->column());
//        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return '';
//        return <<<JS
//if (!$.inArray(value, $statuses)) {
//    messages.push($message);
//}
//JS;
    }

}
