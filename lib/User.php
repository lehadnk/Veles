<?php
/**
 * @file    User.php
 * @brief   Класс User
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Мар 05 21:39:43 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class   User
 * @brief   Модель пользователя
 */
class User extends AbstractModel
{
    const TBL_NAME      = 'users';
    const TBL_USER_INFO = 'users_info';

    // Группы пользователя
    const ADMIN      = 1;
    const MODERATOR  = 2;
    const REGISTERED = 4;
    const GUEST      = 8;
    const DELETED    = 16;

    /**
     * @fn      auth
     * @brief   Метод для авторизации пользователя
     *
     * @return  bool
     */
    final public function auth()
    {
        $auth = new Auth($this);

        return $auth;
    }

    /**
     * @fn      hasAccess
     * @brief   Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     *
     * @return  bool
     */
    final public function hasAccess($groups)
    {
        $result = FALSE;
        // Проверяем есть ли в группах пользователя определённый бит,
        // соответствующий нужной группе.
        foreach ($groups as $group) {
            if (($this->group & $group) === $group) {
                $result = TRUE;
            }
        }

        return $result;
    }

     /**
     * @fn      findActive
     * @brief   Метод для получения данных не удалённого пользователя
     *
     * @param   array $params id либо email пользователя
     * @return  bool
     */
    final public function findActive($params)
    {
        $where = '';
        foreach ($params as $key => $value) {
            if (is_string($value))
                $value = "'$value'";

            $where .= "`$key` = $value && ";
        }

        $where .= '`group` & ' . self::DELETED . ' = 0';

        $sql = '
            SELECT
                `id`, `email`, `hash`, `group`, `last_login`
            FROM
                `' . self::TBL_NAME . '`
            WHERE
                ' . $where . '
            LIMIT 1
        ';

        $result = Db::q($sql);

        foreach ($result as $name => $value)
            $this->$name = $value;

        return $result;
    }

    /**
     * @fn    getId
     * @brief Метод для получения ID пользователя
     */
    final public function getId()
    {
        return (isset($this->id)) ? $this->id : FALSE;
    }

    /**
     * @fn    getHash
     * @brief Метод для получения хэша пользователя, взятого из базы
     */
    final public function getHash()
    {
        return (isset($this->hash)) ? $this->hash : FALSE;
    }

    /**
     * @fn    getCookieHash
     * @brief Метод для получения хэша для кук
     */
    final public function getCookieHash()
    {
        return (isset($this->hash)) ? substr($this->hash, 29) : FALSE;
    }

    /**
     * @fn    getSalt
     * @brief Метод для получения соли хэша
     */
    final public function getSalt()
    {
        return (isset($this->hash)) ? substr($this->hash, 0, 28) : FALSE;
    }

     /**
     * @fn      delete
     * @brief   Метод для удаления пользователя
     *
     * @return  bool
     */
    final public function delete()
    {
        $this->group |= self::DELETED;
        return $this->save();
    }
}
