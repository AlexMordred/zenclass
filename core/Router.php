<?php

namespace Core;

class Router
{
    /**
     * Коллекция доступных маршрутов
     *
     * @var array
     */
    protected static $routes = [];

    /**
     * Добавляем "/" в конец маршрута, если его там нет
     *
     * @param string $path исходный маршрут
     * @return string маршрут со слешем в конце
     */
    private static function normalizePath($path)
    {
        return $path[-1] !== '/' ? "{$path}/" : $path;
    }

    /**
     * Возвращаем название контроллера и метода, на которые ссылается маршрут
     *
     * @param string $uri путь (с URL параметрами), к которому обратился пользователь
     * @return array [контроллер, метод, параметры]
     */
    public static function resolveRoute($uri)
    {
        $path = self::normalizePath(parse_url($uri)['path']);

        $index = array_search($path, array_column(self::$routes, 'path'));

        if ($index === false) {
            abort(404, "Маршрут {$path} не найден");
        }

        $route = self::$routes[$index];

        if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
            abort(405, "Метод {$_SERVER['REQUEST_METHOD']} не разрешен.");
        }

        return $route['action'];
    }

    /**
     * Добавить маршрут в коллекцию
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    private static function addRoute($method, $uri = null, $action = null)
    {
        if ($method && $uri) {
            array_push(self::$routes, [
                'method' => $method,
                'path' => self::normalizePath($uri),
                'action' => $action,
            ]);
        }
    }

    /**
     * Добавить GET маршрут в коллекцию
     *
     * @param string $uri
     * @param string $action
     * @return void
     */
    public static function get($uri = null, $action = null)
    {
        self::addRoute('GET', $uri, $action);
    }

    /**
     * Добавить POST маршрут в коллекцию
     *
     * @param string $uri
     * @param string $action
     * @return void
     */
    public static function post($uri = null, $action = null)
    {
        self::addRoute('POST', $uri, $action);
    }
}
