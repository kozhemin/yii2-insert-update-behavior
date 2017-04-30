<?php
/**
 * @link https://github.com/kozhemin/yii2-insert-update-behavior
 * @copyright Copyright (c) 2017 Kozhemin Egor
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace kozhemin\dbHelper;

use yii\base\Behavior;

/**
 * Insert Ignore/Update behavior for Yii2
 *
 * For example:
 *
 * ```php
 *  public function behaviors()
 *   {
 *       return[
 *           \kozhemin\dbHelper\InsertUpdate::className(),
 *       ];
 *   }
 * ```
 *
 * @author Kozhemin
 */

class InsertUpdate extends Behavior
{

    /**
     * Create Query INSERT ... ON DUPLICATE KEY UPDATE ...
     *
     * @param array $dataInsert
     * @param null $columns
     *
     * @return bool
     */
    public function insertUpdate(array $dataInsert, $columns = null)
    {
        if (!$dataInsert) {
            return false;
        }

        $db = $this->owner->getDb();
        $onDuplicateKeyValues = [];

        if (!$columns) {
            $columns = $this->owner->attributes();
        }

        foreach ($columns as $itemColumn) {
            $column = $db->getSchema()->quoteColumnName($itemColumn);
            $onDuplicateKeyValues[] = $column . ' = VALUES(' . $column . ')';
        }

        $sql = $db->queryBuilder->batchInsert($this->owner->tableName(), $columns, $dataInsert);
        $sql .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', $onDuplicateKeyValues);
        $db->createCommand($sql)->execute();
    }

    /**
     * Create Query INSERT IGNORE
     *
     * @param array $dataInsert
     * @param null $columns
     *
     * @return bool
     */
    public function insertIgnore(array $dataInsert, $columns = null)
    {
        if (!$dataInsert) {
            return false;
        }

        $db = $this->owner->getDb();
        if (!$columns) {
            $columns = $this->owner->attributes();
        }

        $sql = $db->queryBuilder->batchInsert($this->owner->tableName(), $columns, $dataInsert);
        $sql = str_replace('INSERT INTO', 'INSERT IGNORE', $sql);
        $db->createCommand($sql)->execute();
    }

}