<?php
/**
 * Вспомогательный класс для формирования запросов
 * @file    QueryBuilder.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 21:55:54 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles\DataBase;

use \Exception,
    \Veles\DataBase\DbPaginator;

/**
 * Класс QueryBuilder
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class QueryBuilder
{
    /**
     * Построение sql-запроса для insert
     * @param AbstractModel $model Экземпляр модели
     * @return string
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function insert($model)
    {
        $arr = array('fields' => '', 'values' => '');

        foreach ($model::$map as $property => $value) {
            $value = self::sanitize($model, $property);

            if (null === $value) continue;

            $arr['fields'] .= "`$property`, ";
            $arr['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
        }

        array_walk($arr, function(&$val) {
            $val = rtrim($val, ', ');
        });

        $sql = '
            INSERT
                `' . $model::TBL_NAME . "`
                ($arr[fields])
            VALUES
                ($arr[values])
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для update
     * @param AbstractModel $model Экземпляр модели
     * @return string $sql
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function update($model)
    {
        $params = '';

        $properties = array_keys($model::$map);
        foreach ($properties as $property) {
            $value = self::sanitize($model, $property);

            if (null === $value || 'id' === $property) continue;

            $value = (is_string($value)) ? "'$value'" : $value;
            $params .= "`$property` = $value, ";
        }

        $params = rtrim($params, ', ');

        $sql = '
            UPDATE
                `' . $model::TBL_NAME . "`
            SET
                $params
            WHERE
                id = $model->id
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для select
     * @param AbstractModel $model Экземпляр модели
     * @param int $id primary key
     * @return string $sql
     */
    final public static function getById($model, $id)
    {
        $id = (int) $id;

        $sql = '
            SELECT *
            FROM
                `' . $model::TBL_NAME . "`
            WHERE
                `id` = $id
            LIMIT 1
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для delete
     * @param AbstractModel $model Экземпляр модели
     * @param array $ids Массив ID для удаления
     * @return string $sql
     */
    final public static function delete($model, $ids)
    {
        if (!$ids) {
            if (!isset($model->id)) {
                throw new Exception('Не найден id модели!');
            }

            $ids = $model->id;
        }

        if (!is_array($ids)) $ids = array($ids);

        array_walk($ids, function(&$value) {
            $value = (int) $value;
        });

        $ids = implode(',', $ids);

        $sql = '
            DELETE FROM
                `' . $model::TBL_NAME . "`
            WHERE
                id IN ($ids)
        ";

        return $sql;
    }

    /**
     * Построение запроса получения списка объектов
     * @param AbstractModel $model Экземпляр модели
     * @param DbFilter $filter Экземпляр фильтра
     * @param DbPaginator $pager Экземпляр пагинатора
     * @return string
     */
    final public static function find($model, $filter)
    {
        $fields = '';
        $select = 'SELECT';
        $where  = '';
        $group  = '';
        $having = '';
        $order  = '';
        $limit  = '';

        $properties = array_keys($model::$map);
        foreach ($properties as $property) {
            $fields .= "`$property`, ";
        }

        $fields = rtrim($fields, ', ');

        if ($filter instanceof DbFilter) {
            $where  = $filter->getWhere();
            $group  = $filter->getGroup();
            $having = $filter->getHaving();
            $order  = $filter->getOrder();
        }

        $sql = "
            $select
                $fields
            FROM
                `" . $model::TBL_NAME . "`
            $where
            $group
            $having
            $order
            $limit
        ";

        return $sql;
    }

    /**
     * Построение произвольного запроса с постраничным выводом
     * @param string $sql Запрос
     * @param DbPaginator $pager Экземпляр постраничного вывода
     * @return string
     */
    final public static function setPage($sql, $pager)
    {
        if ($pager instanceof DbPaginator) {
            return str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql) . $pager->getSqlLimit();
        }

        return $sql;
    }

    /**
     * Функция безопасности переменных
     * @param  $arg
     * @return mixed
     */
    private static function sanitize($model, $property)
    {
        if (!isset($model::$map[$property])) {
            throw new Exception (
                "Неизвестное свойство \"$property\" модели " . get_class($model)
            );
        }

        if (!isset($model->$property))
            return null;

        if (!isset($model::$map[$property])) {
            throw new Exception (
                "Неизвестный тип данных {$model::$map[$property]} в запросе"
            );
        }

        switch ($model::$map[$property]) {
            case 'int':
                $value = (int) $model->$property;
                break;
            case 'float':
                $value = (float) $model->$property;
                break;
            case 'string':
                $value = mysql_real_escape_string((string) $model->$property);
                break;
        }

        return $value;
    }
}
