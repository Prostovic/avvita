<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 09.12.2015
 * Time: 15:34
 */

namespace app\components;

use yii;
use yii\base\InvalidParamException;
use XSLTProcessor;
use DOMDocument;
use XMLReader;

class XmlConverter {

    /**
     * @var $xsl string xsl for convertion
     * xsl для преобразования xml
     */

    public $xsl = null;
    /**
     * @var $fields array fields list for convrtions
     * Массив с полями для конвертации,
     * ключ - название поля в таблице,
     * значение -
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

    public function read()
    {
        if (($this->filePath === null) || !file_exists($this->filePath)) {
            throw new InvalidParamException('Нужно указать файл для чтения');
        }

        if ($this->className === null) {
            throw new InvalidParamException('Нужно указать класс для записи данных');
        }

        if (count($this->fields) == 0) {
            throw new InvalidParamException('Нужно указать поля для импорта данных');
        }

//        if ( $this->xsl == null) {
//            throw new InvalidParamException('Нужно указать таблицу стилей для преобразования');
//        }

        $sClass = $this->className;
/*
        $xslt = new XSLTProcessor();
        $xsl = new DOMDocument();
        $xsl->loadXML($this->xsl);

        $xslt->importStylesheet($xsl);

        $xml = new DOMDocument();
        $xml->load($this->filePath);

        $xml->encoding = 'UTF-8';
        $xml->save(dirname($this->filePath) . DIRECTORY_SEPARATOR . 'save-' . basename($this->filePath));

        $results = $xslt->transformToXML($xml);
        Yii::info('Results XML: ' . $results);
*/
        $reader = new XMLReader();
        $reader->open($this->filePath);
        $item = array();
        $nEl = 0;
        $bOk = true;
        while ($reader->read()) {
            switch ($reader->nodeType) {
                case (XMLReader::ELEMENT):
                    // если находим в xml элемент <item> начинаем обрабатывать его
                    if ($reader->localName == 'BONUS') {
                        // мы будем формировать массив который будет содержать все дочерние элементы элемента <item>
                        $item = array();
//                        while ($reader->read()){
//                            if ($reader->nodeType == XMLReader::ELEMENT) {
//                                $name = strtolower($reader->localName);
                                while ($reader->moveToNextAttribute()){
                                    // здесь мы получаем атрибуты если они есть
                                    $sVal = $reader->value;
                                    // тут мы заменяем запятую в нецелых числах на точку
                                    if( preg_match('|^[\\d]+,[\\d]+$|', $sVal) ) {
                                        $sVal = str_replace(',', '.', $sVal);
                                    }
                                    $item['__attribs'][$reader->localName] = $sVal;
                                }
                                $reader->read();
                                if (isset($item) && is_array($item)){
                                    $item['value'] = $reader->value;
                                }else
                                    $item = $reader->value;

//                            }
//                            if ($reader->nodeType == XMLReader::END_ELEMENT && $reader->localName == 'item')
//                                break;
//                        }
                        // в этом месте мы уже имеем сформированный массив и можем передать его на какую либо обработку
                        $nEl++;
                        Yii::info('Element ' . $nEl . ' : ' . print_r($item, true));

                        $aSearch = [
                            'doc_key' => $item['__attribs']['НомерДокумента'],
                            'doc_title' => $item['__attribs']['НоменклатураХарактеристика'],
                        ];
                        $ob = $sClass::findOne($aSearch);
                        if( $ob === null ) {
                            $ob = new $sClass;
                        }
                        foreach($this->fields As $k=>$v) {
                            $ob->$k = $item['__attribs'][$v];
                        }
                        if( !$ob->save() ) {
                            Yii::warning('Error save data ' . print_r($item, true) . "\n" . print_r($ob->getErrors(), true));
                            Yii::$app->session->setFlash('danger', 'Ошибка импорта данных.');
                            $bOk = false;
                            break;
                        }
                    }
            }
        }
        return $bOk;
    }

}