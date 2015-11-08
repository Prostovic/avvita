<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 08.11.2015
 * Time: 15:28
 */

namespace app\components;

use yii\db\Schema;
use yii\db\Migration;
use yii;

class BaseMigration extends Migration {

    public function refreshCache()
    {
        Yii::$app->db->schema->refresh();
        Yii::$app->db->schema->getTableSchemas();
        $this->chmodCache();

    }

    public function chmodCache($sDir = null, $sOwn = null) {
        if( $sDir === null ) {
            $sDir = Yii::getAlias('@runtime/cache');
        }

        if( !function_exists('posix_getuid') ) {
            return;
        }
        else if($sOwn === null) {
            $processUser = posix_getpwuid(posix_getuid());
            $sOwn = $processUser['name'];
        }

        if( $hd = opendir($sDir) ) {
            while( false !== ($f = readdir($hd)) ) {
                if( ($f == '.') || ($f == '..') ) {
                    continue;
                }
                $sf = $sDir . DIRECTORY_SEPARATOR . $f;
                if( is_dir($sf) ) {
                    $this->chmodCache($sDir, $sOwn);
                }
                else {
                    chmod($sf, 0777);
                }
            }

            closedir($hd);
        }

    }

}