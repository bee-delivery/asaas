<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace luanrodrigues\asaas\src\Exceptions;

use Exception;

/**
 * Description of CobrancaException
 *
 * @author Rafael
 */
class CobrancaException extends Exception{
    public static function invalidInvoice()
    {
        /*
         * 'customer'             => '',
                'billingType'          => '',
                'value'                => '',
                'dueDate'
        */
        return new static('Os dados fornecidos para a cobrança não são válidos. Tipo: Array | Keys: "customer", "billingType", "value" e "dueDate".');
    }
}
