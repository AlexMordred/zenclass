<?php

namespace App\Controllers;

use Core\Controller;
use Core\Query;

class SessionParticipantsController extends Controller
{
    public function store()
    {
        list($session, $user) = $this->validate();

        // Check if there are still vacant places in the session
        $participants = (new Query('SessionParticipant'))
            ->where('SessionId', '=', $session['ID'])
            ->get();

        if (count($participants) >= $session['MaxParticipants']) {
            return response()->response(null, 'Извините, все места заняты');
        }
        
        $insert = (new Query('SessionParticipant'))->insert([
            'SessionId' => $session['ID'],
            'ParticipantId' => $user['ID'],
        ]);

        if ($insert) {
            return response()->response(null, "Спасибо, вы успешно записаны!");
        } else {
            abort(500, 'Неизвестная ошибка. Не удалось записаться на лекцию.');
        }
    }

    public function validate()
    {
        if (!isset($_POST['sessionId'])) {
            abort(422, 'Не найден обязательный параметр sessionId.');
        }

        if (!isset($_POST['userEmail'])) {
            abort(422, 'Не найден обязательный параметр userEmail.');
        }

        $session = (new Query('Session'))->where('id', '=', intval($_POST['sessionId']))
            ->first();

        if (!$session) {
            abort(404, 'Лекция с указанным sessionId не найдена.');
        }

        $user = (new Query('Participant'))->where('Email', '=', $_POST['userEmail'])
            ->first();

        if (!$user) {
            abort(404, 'Пользователь с указанным userEmail не найден.');
        }

        // Check if the user already participates in the session
        $participates = (new Query('SessionParticipant'))
            ->where('SessionId', '=', $session['ID'])
            ->where('ParticipantId', '=', $user['ID'])
            ->first();

        if ($participates) {
            abort(422, 'Данный пользователь уже участвует в данной лекции.');
        }

        return [$session, $user];
    }
}
