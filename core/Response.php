<?php

namespace Core;

class Response
{
    /**
     * Устанавливает HTTP код. Возвращает данные в формате JSON, если таковые присутствуют
     *
     * @param array $data данные дла конвертации в JSON
     * @param integer $status HTTP код статуса для ответа
     * @return JSON
     */
    public function response($data = null, $message = '', $status = 200)
    {
        http_response_code($status);

        header('Content-type: application/json');

        $response = ['status' => $status < 400 ? 'ok' : 'error'];

        if ($data !== null) {
            $response = array_merge($response, ['payload' => $data]);
        }

        if ($message) {
            $response = array_merge($response, ['message' => $message]);
        }

        return json_encode($response);
    }

    /**
     * Возвзращает пустой ответ со статусом 200
     *
     * @return JSON
     */
    public function ok($message = null)
    {
        return $this->response(null, $message);
    }
}
