<?php

namespace luanrodrigues\asaas;

use Exception;
use luanrodrigues\asaas\src\Exceptions\ClienteException;

class Cliente
{
    
    public $http;
    protected $cliente;
    
    public function __construct($apiKey)
    {
        $this->http = new Connection($apiKey);
    }

    /**
     * Recupera todos os clientes
     *
     * @see https://asaasv3.docs.apiary.io/#reference/0/clientes/listar-clientes
     * @param String name
     * @return json
     */
    public function all($name = null)
    {
        return $this->http->get('/customers' .'?&name='.$name.'&offset=0&limit=3000');
    }
    
    /**
     * Cria um novo cliente.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/clientes/criar-novo-cliente
     * @param Array $cliente
     * @return Boolean
     */
    public function create($cliente)
    {
        $cliente = $this->setCliente($cliente);
        return $this->http->post('/customers', ['form_params' => $cliente]);
    }

    /**
     * Recupera um cliente pelo id.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/clientes/recuperar-um-unico-cliente
     * @param String $id
     * @return json
     */
    public function find($id)
    {
        return $this->http->get('/customers' .'/'. $id);
    }

    /**
     * Atualiza um cliente.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/clientes/recuperar-um-unico-cliente
     * @param String $id
     * @param Array $param
     * @return json
     */
    public function update($id, $param)
    {

        $cliente = $this->find($id);
        $cliente = $this->setCliente((array) $cliente['response']);
        $cliente = array_merge($cliente, $param);

        return $this->http->post('/customers' .'/'. $id, ['form_params' => $cliente]);
    }


    /**
     * Remove um cliente.
     *
     * @see https://asaasv3.docs.apiary.io/#reference/0/clientes/remover-cliente
     * @param String id
     * @return Boolean
     */
    public function delete($id)
    {
        return $this->http->delete('/customers' .'/'. $id);
    }


    /**
     * Faz merge nas informações do cliente.
     *
     * @param Array $cliente
     * @return Array
     */
    public function setCliente($cliente)
    {
        try {

            if ( ! $this->cliente_valid($cliente) ) {
                throw ClienteException::invalidClient();
            }
            
            $this->cliente = array(
                'name'                 => '',
                'cpfCnpj'              => '',
                'email'                => '',
                'phone'                => '',
                'mobilePhone'          => '',
                'address'              => '',
                'addressNumber'        => '',
                'complement'           => '',
                'province'             => '',
                'postalCode'           => '',
                'externalReference'    => '',
                'notificationDisabled' => '',
                'additionalEmails'     => ''
            );

            $this->cliente = array_merge($this->cliente, $cliente);
            return $this->cliente;
            
        } catch (Exception $e) {
            return 'Erro ao definir o cliente. - ' . $e->getMessage();
        }
    }
    
    /**
     * Verifica se os dados do cliente são válidos.
     * 
     * @param array $cliente
     * @return Boolean
     */
    public function cliente_valid($cliente)
    {
        return ! ( empty($cliente['name']) OR empty($cliente['cpfCnpj']) OR empty($cliente['email']) );
    }
}