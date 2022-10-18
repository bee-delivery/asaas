<?php

namespace luanrodrigues\asaas\src;


use Exception;
use luanrodrigues\asaas\src\Exceptions\ClienteException;
use luanrodrigues\asaas\src\Connection;
use luanrodrigues\asaas\src\Exceptions\ContaException;

class Conta
{
    
    public $http;
    protected $conta;
    
    public function __construct()
    {
        $apiKey         = env('ASAAS_API_KEY', '');
        $this->http     = new Connection($apiKey, 'v2');
    }

    
    /**
     * Cria um novo conta.
     *
     * @see https://asaasaccounts.docs.apiary.io/#reference/0/contas/criar-conta
     * @param Array $conta
     * @return Boolean
     */
    public function create($conta)
    {
        $conta = $this->setConta($conta);
        return $this->http->post('/accounts', ['form_params' => $conta]);
    }

    /**
     * Faz merge nas informações do conta.
     *
     * @param Array $conta
     * @return Array
     */
    public function setConta($conta)
    {
        try {


            if ( ! $this->conta_valid($conta) ) {
                throw ContaException::invalidConta();
            }

            $this->conta = array(
                'name'                 => '',
                'cpfCnpj'              => '',
                'companyType'          => '',
                'email'                => '',
                'phone'                => '',
                'mobilePhone'          => '',
                'address'              => '',
                'addressNumber'        => '',
                'complement'           => '',
                'province'             => '',
                'postalCode'           => '',
            );

            $this->conta = array_merge($this->conta, $conta);
            return $this->conta;

        } catch (Exception $e) {
            return 'Erro ao definir a conta. - ' . $e->getMessage();
        }
    }

    /**
     * Verifica se os dados da conta são válidos.
     *
     * @param array $conta
     * @return Boolean
     */
    public function conta_valid($conta)
    {
        return ! ( empty($conta['name']) OR empty($conta['cpfCnpj']) OR empty($conta['companyType']) OR empty($conta['email']) OR empty($conta['phone']) OR empty($conta['mobilePhone'])  OR empty($conta['address'])  OR empty($conta['addressNumber']) OR empty($conta['province']) OR empty($conta['postalCode']) );
    }

}