<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 25.11.2015
 * Time: 6:39
 */

namespace app\components;

use yii;
use yii\base\InvalidParamException;
use \PHPExcel;
use \PHPExcel_CachedObjectStorageFactory;
use \PHPExcel_Settings;
use \PHPExcel_IOFactory;

class ExcelConverter {
    /**
     * @var $fields array fields list for convrtions
     * Массив с полями для конвертации,
     * ключ - название поля в таблице,
     * значение - номер столбца в Excel файле
     */
    public $fields = [];

    /**
     * @var $keyfields array fields list for search existing values
     * Массив с полями для поиска существующих данных,
     * значение - название поля в таблице
     */
    public $keyfields = [];

    /**
     * @var $className string ActiveRecord Класс для записи данных
     */
    public $className = null;

    /**
     * @var $startRow int первая сртока с данными
     */
    public $startRow = 0;

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

        \Yii::info('ExcelConverter:: this->filePath = ' . $this->filePath);
        $objPHPExcel = PHPExcel_IOFactory::load($this->filePath);

        $oSheet = $objPHPExcel->getSheet(0);

        $nEmpty = 3;
        $nRow = $this->startRow;
        $nCou = 5;
        $sClass = $this->className;

        while($nEmpty > 0) {
            $nRow++;

            $aSearch = [];
            foreach($this->keyfields As $v) {
                if( !isset($this->fields[$v]) ) {
                    throw new InvalidParamException('Not found search field "' . $v . '" in field list ['.implode(', ', array_keys($this->fields)).']');
                }
                $aSearch[$v] = trim($oSheet->getCellByColumnAndRow($this->fields[$v], $nRow)->getValue());
            }

//            Yii::info('aSearch: ' . print_r($aSearch, true));

            $ob = null;
            if( count($aSearch) > 0 ) {
                $ob = $sClass::findOne($aSearch);
//                Yii::info('Find One: ' . print_r($ob->attributes, true));
            }
            if( $ob === null ) {
                $ob = new $sClass;
            }

            $sReg = '';
            foreach($this->fields As $fld => $col) {
                Yii::info('ExcelConverter::read() ob->'.$fld.' = [' . $nRow . ', ' . $col . '] = ' . trim($oSheet->getCellByColumnAndRow($col, $nRow)->getValue()));
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