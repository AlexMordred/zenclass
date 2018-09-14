<?php

namespace Core;

class DB
{
    protected static $db;

    /**
     * A PDO object
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * List of existing/allowed tables
     *
     * @var array
     */
    protected static $tables = [];

    /**
     * Инициализация синглтона для работы с БД, а так же объекта PDO
     *
     * @return Core\DB
     */
    public static function init()
    {
        if (self::$db == null) {
            self::$db = new self();
        }

        if (self::$db->pdo == null) {
            require __DIR__ . '/../config.php';

            self::$db->pdo = new \PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS
            );

            // Set $tables
            if (is_array(DB_TABLES)) {
                self::$tables = DB_TABLES;
            } else {
                throw new \Exception('Константа DB_TABLES в config.php должна быть массивом.');
            }
        }

        return self::$db;
    }

    /**
     * Возвращает объект PDO
     *
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }

    /**
     * Getter for the $tables array
     *
     * @return array $tables
     */
    public static function getTables() : array
    {
        return self::$tables;
    }
}
