<?php

namespace luanrodrigues\asaas;



use Illuminate\Support\Facades\Log;
use luanrodrigues\asaas\src\Cartao;
use luanrodrigues\asaas\src\Cliente;
use luanrodrigues\asaas\src\Cobranca;
use luanrodrigues\asaas\src\Conta;

class Asaas
{

    public function conta(){
        return new Conta();
    }

    public function cliente($apiKey){
        return new Cliente($apiKey);
    }

    public function cobranca($apiKey){
        return new Cobranca($apiKey);
    }

    public function cartao($apiKey){
        return new Cartao($apiKey);
    }
}