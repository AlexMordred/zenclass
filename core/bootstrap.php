<?php

use Core\Router;
use Core\Log;

// Отлавливание исключений
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

try {
    // Создаем необходимые таблицы в БД, если они еще не созданы
    db()->install();

    // Загружаем маршруты
    require_once __DIR__ . '/../app/routes.php';

    // Определяем действие, соответствующее текущему маршруту
    $uri = $_SERVER['REQUEST_URI'];
    $action = Router::resolveRoute($uri);

    // If the action is a controller@method reference
    if (is_string($action)) {
        $actionParts = explode('@', $action);

        if (count($actionParts) != 2) {
            throw new \Exception("Неверное действие '{$action}' для маршрута '{$uri}'.");
        }

        $controller = "App\\Controllers\\{$actionParts[0]}";
        $method = $actionParts[1];

        // Проверяем существуют ли указанные класс контроллера и метод в нем
        if (!class_exists($controller)) {
            throw new \Exception("Контроллер {$controller} не существует.");
        }

        if (!method_exists($controller, $method)) {
            throw new \Exception("Метод {$method} не существует в контроллере {$controller}.");
        }

        // Выполняем метод из контроллера и возвращаем результат
        echo (new $controller())->{$method}();
    } elseif (is_callable($action)) {
        // If the action is a closure
        echo $action();
    } else {
        throw new \Exception("Маршруту '{$uri}' не назначено действие.");
    }
} catch (\Exception $e) {
    // Т.к. это API - возвращаем JSON ответ
    echo response()->response(null, 'Ошибка на сервере. Пожлауйста, свяжитесь с администратором.', 500);

    // Log the actual error for the administrator
    Log::error($e->xdebug_message);
}

// Завершаем скрипт
exit();
