<?php
/**
 * Абстрактный класс для постраничного вывода
 * @file    DbPaginator.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 07 23:04:47 2012
 * @version
 */

namespace Veles\DataBase;

/**
 * Класс DbPaginator
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbPaginator
{
    protected $offset = 0;
    protected $limit  = 5;

    /**
     * Метод получения offset
     * @return int
     */
    final public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Метод получения limit
     * @return int
     */
    final public function getLimit()
    {
        return "LIMIT {$this->limit}";
    }
}