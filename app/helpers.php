<?php

if(!function_exists('moneyUStoBR')) {
    function moneyUStoBR($valor, $decimal = 2): string
    {
        if($valor != ''){
            return number_format($valor,$decimal,',', '.');
        }
        return '0,00';
    }
}
