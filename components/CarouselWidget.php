<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 10.04.2016
 * Time: 15:38
 */

namespace app\components;
use yii\base\InvalidParamException;
use yii\base\Widget;


class CarouselWidget extends Widget {

    /**
     * @var $models array список моделей для вывода
     */
    public $models = [];

    /**
     * @var $view string view для вывода
     */
    public $view = null;

    /**
     * @var $script string скрипт для вывода
     */
    public $script = '';

    /**
     * @var $emptyMessage string сообщение при отсутствии данных
     */
    public $emptyMessage = 'No data in widget';

    public function run() {
        if( !empty($this->models) ) {
            if( empty($this->view) ) {
                throw new InvalidParamException('No view for widget');
            }
            return \Yii::$app->controller->renderPartial(
                $this->view,
                [
                    'data' => $this->models,
                ]
            );
        }
        else {
            return $this->emptyMessage;
        }
    }
}