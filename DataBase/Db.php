<?php
/**
 * Класс с методами обработки и вызова запросов
 * @file    DbBase.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Thu May 2 11:51:05 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

/**
 * Class Db
 *
 * Класс с методами обработки и вызова запросов
 * Типы плейсхолдеров указываются в mysqli-формате:
 * i - integer
 * d - float/double
 * s - string
 * b - binary
 * Если для плейсходеров не указываются типы, используется тип string
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Db extends DbTransactionHandler
{
	/**
	 * Получение значения столбца таблицы
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return string
	 */
	public static function value($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->value($sql, $params, $types);
	}

	/**
	 * Получение строки таблицы в виде ассоциативного массива
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return array
	 */
	public static function row($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->row($sql, $params, $types);
	}

	/**
	 * Получение результата в виде коллекции ассоциативных массивов
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return mixed
	 */
	public static function rows($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->rows($sql, $params, $types);
	}

	/**
	 * Запуск произвольного не SELECT запроса
	 *
	 * @param string $sql Non-SELECT SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return bool
	 */
	public static function query($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->query($sql, $params, $types);
	}
}
