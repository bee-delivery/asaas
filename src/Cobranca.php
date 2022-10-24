<?php

namespace luanrodrigues\asaas;

use luanrodrigues\asaas\src\Exceptions\CobrancaException;

class Cobranca
{

    public $http;
    protected $cobranca;

    public function __construct($apiKey)
    {
        $this->http = new Connection($apiKey);
    }

    /**
     * Recupera todos as cobrancas
     *
     * @see https://asaasv3.docs.apiary.io/#reference/0/cobrancas/listar-cobrancas
     * @param String name
     * @return json
     */
    public function all()
    {
        return $this->http->get('/payments' .'?&offset=0&limit=3000');
    }


    /**
     * Cria nova cobrança.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/cobrancas/criar-nova-cobranca
     * @param String $id
     * @param Array $param
     * @return Array
     */
    public function create($cobranca)
    {
        return $this->http->post('/payments', ['json' => $cobranca]);
    }


    /**
     * Recupera cobrança existente.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/cobrancas/recuperar-uma-unica-cobranca
     * @param String $id
     * @param Array $param
     * @return Array
     */
    public function find($id)
    {
        return $this->http->get('/payments' .'/'. $id);
    }


    public function findPixQrCode($id)
    {
        return $this->http->get('/payments' .'/'. $id . '/pixQrCode');
    }

    /**
     * Faz atualiza cobrança existente.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/cobrancas/atualizar-cobranca-existente
     * @param String $id
     * @param Array $param
     * @return Array
     */
    public function update($id, $param)
    {

        $cobranca = $this->find($id);
        $cobranca = (array) $cobranca['response'];
        $cobranca = $this->setCobranca($cobranca);
        $cobranca = array_merge($cobranca, $param);

        return $this->http->post('/payments' .'/'. $id, ['form_params' => $cobranca]);
    }

    /**
     * Quita a cobrança como pagamento em dinheiro
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/cobrancas/confirmar-recebimento-em-dinheiro
     * @param String $id
     * @param Array $param
     * @return Array
     */
    public function payed($id, $param)
    {
        return $this->http->post('/payments' .'/'. $id .'/receiveInCash', ['form_params' => $param] );
    }

    /**
     * Estorna a cobrança feita no cartão de crédito
     *
     * @see https://asaasv3.docs.apiary.io/#reference/0/cobrancas/estornar-cobranca
     * @param String $id
     * @param Array $param
     * @return Array
     */
    public function refund($id, $param)
    {
        return $this->http->post('/payments' .'/'. $id .'/refund', ['json' => $param] );
    }

    /**
     * Remove uma cobrança existente.
     *
     * @see https://asaasv3.docs.apiary.io/reference/0/cobrancas/remover-cobranca
     * @param String $id
     * @return Json
     */
    public function destroy($id)
    {
        return $this->http->delete('/payments' .'/'. $id);
    }

    /**
     * Faz merge nas informações da cobrança.
     *
     * @see
     * @param Array $cobranca
     * @return Array
     */
    public function setCobranca($cobranca)
    {
        try {

            if ( ! $this->invoice_valid($cobranca) ) {
                throw CobrancaException::invalidInvoice();
            }

            $this->cobranca = array(
                'customer'             => '',
                'billingType'          => '',
                'value'                => '',
                'dueDate'              => '',
                'description'          => '',
                'externalReference'    => ''
            );

            $this->cobranca = array_merge($this->cobranca, $cobranca);
            return $this->cobranca;

        } catch (\Exception $e) {
            return 'Erro ao definir a cobrança. - ' . $e->getMessage();
        }
    }

    /**
     * Verifica se os dados da cobrança são válidos.
     *
     * @param array $cobranca
     * @return Boolean
     */
    public function invoice_valid($cobranca)
    {
        return ! ( empty($cobranca['customer']) OR empty($cobranca['billingType']) OR empty($cobranca['value']) OR empty($cobranca['dueDate']) );
    }
}