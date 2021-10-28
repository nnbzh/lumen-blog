<?php


namespace App\Helpers;


use App\Traits\ApiResponse;
use Laravel\Passport\Exceptions\OAuthServerException;

class OAuthExceptionTranslator
{
    use ApiResponse;

    private static $error;

    public static function mappings($code) {
        $errors = [
            2 => [
                "code"      => 400,
                "message"   => "Тип разрешения на авторизацию (authorization grant) не поддерживается сервером авторизации."
            ],
            3 => [
                "code"      => 400,
                "message"   => "В запросе отсутствует обязательный параметр, он включает недопустимое " .
                    "значение параметра, включает параметр более одного раза или имеет другой неправильный формат."
            ],
            4 => [
                "code"      => 400,
                "message"   => "Тип разрешения на авторизацию (authorization grant) не поддерживается сервером авторизации."
            ],
            6 => [
                "code"      => 401,
                "message"   => "Учетные данные пользователя неверны."
            ],
            7 => [
                "code"      => 500,
                "message"   => "Ошибка сервера."
            ],
            8 => [
                "code"      => 401,
                "message"   => "Токен обновления недействителен."
            ],
            9 => [
                "code"      => 401,
                "message"   => "Владелец ресурса или сервер авторизации отклонил запрос."
            ],
            10 => [
                "code"      => 401,
                "message"   => 'Предоставленное разрешение авторизации (например, код авторизации, учетные данные владельца ресурса) или токен обновления '
                    . 'недействителен, истек, отозван, не соответствует URI перенаправления, используемому в запросе авторизации,'
                    . 'или был выдан другому клиенту.'
            ]
        ];

        return $errors[$code];
    }

    public static function translate(OAuthServerException $exception) {
        $code = $exception->getCode();
        self::$error = self::mappings($code);

        if ($code == 6 || $code == 10) self::$error = self::mappings(6);

        return self::$error;
    }


}