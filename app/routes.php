<?php

namespace App;

use Core\Router;

Router::get('/', function () {
    return response()->response([], 'hi, closure');
});

Router::get('/api', 'ExampleController@index');
