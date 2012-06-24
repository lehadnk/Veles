<?php
/**
 * Класс роутинга
 * @file    Route.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 08:52:41 2012
 * @version
 */

namespace Veles\Routing;

use \Veles\Config,
    \Exception;

/**
 * Класс Route
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Route
{
    private static $page_name  = NULL;
    private static $config     = NULL;

    /**
     * Парсинг конфига и инициализация переменных контроллера и экшена
     */
    private static function init()
    {
        $routes = Config::getParams('routes');
        $q_pos  = strpos($_SERVER['REQUEST_URI'], '?');

        $url = ($q_pos)
            ? substr($_SERVER['REQUEST_URI'], 0, $q_pos)
            : $_SERVER['REQUEST_URI'];

        foreach ($routes as $name => $route) {
            if ($route['class']::check($route['route'], $url)) {
                self::$config    = $route;
                self::$page_name = $name;
                return;
            }
        }

        //TODO: go to 404!
        throw new Exception("URL $url не найден в конфиге роутинга!");
    }

    /**
     * Получение и инициалзация контроллера
     * @return object
     */
    final public static function getController()
    {
        if (!isset(self::$config))
            self::init();

        if (!isset(self::$config['controller']))
            throw new Exception("Не указан контроллер для URL: $url");

        return self::$config['controller'];
    }

    /**
     * Получение имени метода
     * @return string
     */
    final public static function getAction()
    {
        if (!isset(self::$config))
             self::init();

        if (!isset(self::$config['action']))
            throw new Exception("Не указан экшен для URL: $url");

        return self::$config['action'];
    }

    /**
     * Получение имени страницы
     * @return string
     */
    final public static function getPageName()
    {
        if (!isset(self::$page_name)) self::init();

        return self::$page_name;
    }
}
