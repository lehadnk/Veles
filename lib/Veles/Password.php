<?php
/**
 * Класс управления паролем пользователя
 * @file    Password.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Апр 21 15:49:49 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

/**
 * Управление паролем пользователя
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Password {
    /**
     * Проверка хэша пользователя
     * @param $user
     */
    final public static function checkCookieHash(&$user, &$cookie_hash)
    {
        return $user->getCookieHash() === $cookie_hash;
    }

    /**
     * Проверка пароля пользователя при ajax-авторизации
     * @param object $user     User
     * @param string $password Пароль полученый ajax'ом
     */
    final public static function check(&$user, &$password)
    {
        return $user->getHash() === crypt($password, $user->getSalt());
    }
}
