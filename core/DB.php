<?php

namespace Core;

class DB
{
    protected static $db;

    protected $pdo;

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
     * Создает таблицы в БД (если они еще не созданы), необходимые для работы приложения
     *
     * @return void
     */
    public function install()
    {
        //
    }

    /**
     * Очищает указанную таблицу в БД
     *
     * @param string $table название таблицы
     * @return void
     */
    // public function clearTable($table)
    // {
    //     $this->pdo()->exec("TRUNCATE TABLE {$table}");
    // }

    /**
     * Записывает в указанную таблицу в БД указанные строки
     *
     * @param string $table название таблицы
     * @param array $columns столбцы таблицы, в которые вносятся значения
     * @param array $rows строки таблиц (значения), которые неоходимо записать
     * @return void
     */
    // public function insert($table, $columns, $rows)
    // {
    //     $columns = implode(', ', $columns);

    //     $sql = "INSERT INTO {$table} ({$columns}) VALUES ";

    //     // Добавляем placeholder'ы под параметры
    //     foreach ($rows as $key => $row) {
    //         $row = array_fill(0, count($row), '?');
    //         $row = implode(', ', $row);

    //         $sql .= "({$row})";

    //         if ($key < count($rows) - 1) {
    //             $sql .= ',';
    //         }
    //     }

    //     $query = db()->pdo()->prepare($sql);

    //     // Подставляем реальные значения в placeholder'ы
    //     for ($i = 0; $i < count($rows); $i++) {
    //         for ($q = 0; $q < count($rows[$i]); $q++) {
    //             $query->bindParam(($i + 1) * ($q + 1), $rows[$i][$q]);
    //         }
    //     }

    //     $query->execute();
    // }

    /**
     * Возвращает кол-во записей в указанной табилце
     *
     * @param $string $table
     * @return integer кол-во записей
     */
    // public function countTotal($table)
    // {
    //     $result = $this->pdo->query("SELECT COUNT(*) AS count FROM {$table}");

    //     return $result->fetch(\PDO::FETCH_ASSOC)['count'];
    // }
}
