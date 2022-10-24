<?php

namespace luanrodrigues\asaas;

use luanrodrigues\asaas\src\Exceptions\CobrancaException;

class Cartao
{

    public $http;
    protected $card;

    public function __construct($apiKey)
    {
        $this->http = new Connection($apiKey, 'v2');
    }


    /**
     * Tokeniza Cartão de Crédito.
     *
     * @see ??
     * @param Array $param
     * @return Array
     */
    public function tokenize($param)
    {
        return $this->http->post('/creditCard/tokenizeCreditCard', ['json' => $param]);
    }

    /**
     * Realiza Cobrança no cartão de crédito.
     *
     * @see ??
     * @param Array $param
     * @return Array
     */
    public function charge($param)
    {
        return $this->http->post('/creditCard/tokenizeCreditCard', ['json' => $param]);
    }

    /**
     * Faz merge nas informações do cartao.
     *
     * @see
     * @param Array $card
     * @return Array
     */
    public function setCard($card)
    {
        try {

            if ( ! $this->card_valid($card) ) {
                throw CobrancaException::invalidInvoice();
            }

            $this->cartao = array(
                'creditCardHolderFullName'              => '',
                'creditCardHolderEmail'                 => '',
                'creditCardHolderCpfCnpj'               => '',
                'creditCardHolderAddressNumber'         => '',
                'creditCardHolderAddressComplement'     => '',
                'creditCardHolderPostalCode'            => '',
                'creditCardHolderPhone'                 => '',
                'creditCardHolderPhoneDDD'              => '',
                'creditCardHolderMobilePhone'           => '',
                'creditCardHolderMobilePhoneDDD'        => '',
                'creditCardHolderName'                  => '',
                'creditCardCcv'                         => '',
                'creditCardExpiryMonth'                 => '',
                'creditCardNumber'                      => '',
                'creditCardExpiryYear'                  => '',
                'customer'                              => ''
            );

            $this->card = array_merge($this->card, $card);
            return $this->card;

        } catch (\Exception $e) {
            return 'Erro ao definir o cartão de crédito. - ' . $e->getMessage();
        }
    }

    /**
     * Verifica se os dados da cobrança são válidos.
     *
     * @param array $card
     * @return Boolean
     */
    public function card_valid($card)
    {
        return ! (
            empty($cobranca['creditCardHolderFullName']) OR
            empty($cobranca['creditCardHolderEmail']) OR
            empty($cobranca['creditCardHolderCpfCnpj']) OR
            empty($cobranca['creditCardHolderAddressNumber']) OR
            empty($cobranca['creditCardHolderAddressComplement']) OR
            empty($cobranca['creditCardHolderPostalCode']) OR
            empty($cobranca['creditCardHolderMobilePhone']) OR
            empty($cobranca['creditCardHolderMobilePhoneDDD']) OR
            empty($cobranca['creditCardHolderName']) OR
            empty($cobranca['creditCardCcv']) OR
            empty($cobranca['creditCardExpiryMonth']) OR
            empty($cobranca['creditCardNumber']) OR
            empty($cobranca['creditCardExpiryYear']) OR
            empty($cobranca['customer'])
        );
    }

}
