<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 25.11.2015
 * Time: 6:39
 */

namespace app\components;


use yii\base\InvalidParamException;
use \PHPExcel;

class ExcelConverter {
    /**
     * @var $fields array fields list for convrtions
     * Массив с полями для конвертации,
     * ключ - название поля в таблице,
     * значение - номер столбца в Excel файле
     */
    public $fields = [];

    /**
     * @var $className string ActiveRecord Класс для записи данных
     */
    public $className = null;

    /**
     * @var $startRow int первая сртока с данными
     */
    public $startRow = 1;

    /**
     * @var $filePath string Путь к файлу с данными
     */
    public $filePath = null;

    public function read() {
        if( ($this->filePath === null) || !file_exists($this->filePath) ) {
            throw new InvalidParamException('Нужно указать файл для чтения');
        }

        if( $this->className === null ) {
            throw new InvalidParamException('Нужно указать класс для записи данных');
        }

        if( count($this->fields) == 0 ) {
            throw new InvalidParamException('Нужно указать поля для импорта данных');
        }

        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

        $objPHPExcel = PHPExcel_IOFactory::load($this->filePath);

        $oSheet = $objPHPExcel->getSheet(0);

        $nEmpty = 3;
        $nRow = 0;
        $nCou = 5;
        $sClass = $this->className;

        while($nEmpty > 0) {
            $nRow++;

            $ob = new $sClass;

            $sReg = '';
            foreach($this->fields As $fld => $col) {
                $ob->{$fld} = trim($oSheet->getCellByColumnAndRow($col, $nRow)->getValue());
                $sReg .= $ob->{$fld};
            }

            if( $sReg == '' ) {
                $nEmpty--;
                continue;
            }
            $nEmpty = 3;

            if( $nCou-- > 0 ) {
                Yii::info('ExcelConverter::read() attributes = ' . print_r($ob->attributes, true));
            }

            if( !$ob->save() ) {
                Yii::info("ExcelConverter::read() Error save: " . print_r($ob->getErrors(), true));
            }
//            break;
        }
    }

}