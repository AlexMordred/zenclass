<?php

use Core\Router;

Router::get('/api/table', 'DataController@index');
Router::post('/api/sessions/participants', 'SessionParticipantsController@store');
