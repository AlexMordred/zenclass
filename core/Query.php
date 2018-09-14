<?php

namespace Core;

class Query
{
    protected static $operators = ['=', '!=', '>', '>=', '<', '<=', 'LIKE'];

    /**
     * Name of the table to work with
     *
     * @var string
     */
    protected $table;

    /**
     * LIMIT amount
     *
     * @var integer
     */
    protected $limit = 0;

    /**
     * An array of WHERE statements
     *
     * @var array
     */
    protected $where = [];

    /**
     * Query initialization
     *
     * @param string $table table to work with
     */
    public function __construct(string $table)
    {
        // Check if the table exists (is allowed to be operated on)
        if (!in_array($table, DB::getTables())) {
            abort(404, 'Недопустимое значение параметра table.');
        }

        $this->table = $table;
    }

    public function where(string $field = null, string $operator = null, $value = null) : Query
    {
        if (!$field || !$operator) {
            throw new \Exception('Недостающие параметры в Query::where()');
        }

        if (!in_array($operator, self::$operators)) {
            throw new \Exception('Использован неверный оператор в Query::where()');
        }

        array_push($this->where, [
            'sql' => "{$field} {$operator} :where_{$field}",
            'field' => $field,
            'value' => $value,
        ]);

        return $this;
    }

    /**
     * Compiles the final SQL
     *
     * @return string
     */
    public function sql() : string
    {
        $sql = "SELECT * FROM {$this->table}";

        // WHERE
        if (count($this->where) > 0) {
            $where = implode(' AND ', array_column($this->where, 'sql'));

            $sql .= " WHERE {$where}";
        }

        // LIMIT
        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    /**
     * Execute the final query
     *
     * @return \PDOStatement
     */
    public function execute() : \PDOStatement
    {
        $pdo = db()->pdo();

        $query = $pdo->prepare($this->sql());

        // Bind parameters
        foreach ($this->where as $where) {
            $query->bindParam(":where_{$where['field']}", $where['value']);
        }

        // Execute
        $query->execute();

        if ($query->errorCode() != '00000') {
            throw new \Exception($query->errorInfo()[1] . ' - ' . $query->errorInfo()[2]);
        }

        return $query;
    }

    /**
     * Fetch and return all the query results
     *
     * @return array
     */
    public function get()
    {
        return $this->execute()->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Fetch and return the first query results
     *
     * @return array
     */
    public function first()
    {
        $this->limit = 1;

        $result = $this->execute()->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}
