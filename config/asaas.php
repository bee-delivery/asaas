<?php

$url = config('app.asaas_url');

return [
    'base_url_v2'   => $url . 'v2', // Url da API do Asaas
    'base_url'      => $url . 'v3', // Url da API do Asaas
    'api_key'       => env('ASAAS_API_KEY'),  // Sua API KEY
    'mode'          => 'production',        // Opções: 'tests' ou 'production'
];
