<?php

namespace App\Controllers;

use Core\Controller;
use Core\Query;

class DataController extends Controller
{
    public function index()
    {
        if (!isset($_GET['table'])) {
            abort(422, 'Не найден обязательный параметр table.');
        }

        $id = isset($_GET['id']) && intval($_GET['id']) > 0
            ? $_GET['id']
            : null;

        $query = new Query($_GET['table']);

        $results = $id
            ? $query->where('id', '=', $id)->first()
            : $query->get();

        return response()->response($results);
    }
}
