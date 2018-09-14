<?php

namespace App\Controllers;

use Core\Controller;

class DataController extends Controller
{
    public function index()
    {
        if (!isset($_GET['table'])) {
            abort(404, 'Не найден обязательный параметр table.');
        }

        // If the table is not allowed
        if (!in_array($_GET['table'], DB_TABLES)) {
            abort(404, 'Недопустимое значение параметра table.');
        }

        $sql = "SELECT * FROM {$_GET['table']}";

        $id = null;
        if (isset($_GET['id']) && intval($_GET['id']) > 0) {
            $sql .= ' WHERE id=:id';

            $id = intval($_GET['id']);
        }

        $pdo = db()->pdo();

        $query = $pdo->prepare($sql);

        if ($id) {
            $query->bindParam(':id', $_GET['id']);
        }

        $query->execute();

        if ($query->errorCode() != '00000') {
            throw new \Exception($query->errorInfo()[1] . ' - ' . $query->errorInfo()[2]);
        }

        if ($id) {
            $results = $query->fetch(\PDO::FETCH_ASSOC);
        } else {
            $results = $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        return response()->response($results);
    }
}
