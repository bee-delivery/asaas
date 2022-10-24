<?php

namespace luanrodrigues\asaas;

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