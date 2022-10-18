<?php

namespace luanrodrigues\asaas\src\Exceptions;
use Exception;

class ContaException extends Exception{

    public static function invalidConta()
    {
        return new static('Os dados fornecidos para o cadastro do cliente não são válidos. Tipo: Array | Keys: "name", "cpfCnpj" e "email".');
    }
}
