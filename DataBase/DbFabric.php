<?php
/**
 * Фабрика для создания класса драйвера базы данных
 * @file    DbFabric.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 06 13:02:08 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Exception;
use Veles\Config;
use Veles\DataBase\Drivers\iDbDriver;

/**
 * Класс DbFabric
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbFabric
{
    /**
     * Метод для создания класса драйвера базы данных
     * @throws Exception
     * @return iDbDriver
     */
    final public static function getDriver()
    {
        if (null === ($class = Config::getParams('db_driver'))) {
            throw new Exception('Нe указан драйвер для работы с базой!');
        }

        $class_name = "\\Veles\\DataBase\\Drivers\\$class";

        $driver = new $class_name;

        if (!$driver instanceof iDbDriver) {
            throw new Exception('Некорректный Db-драйвер!');
        }

        return new $driver;
    }
}