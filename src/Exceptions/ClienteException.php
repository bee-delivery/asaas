<?php

namespace luanrodrigues\asaas\src\Exceptions;

use Exception;

class ClienteException extends Exception{

    public static function invalidClient()
    {
        return new static('Os dados fornecidos para o cadastro do cliente não são válidos. Tipo: Array | Keys: "name", "cpfCnpj" e "email".');
    }
}
