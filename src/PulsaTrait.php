<?php

namespace Rick20\PPOB;

trait PulsaTrait
{
    private $operators = [
        
        "0814" => 'indosat', "0815" => 'indosat', "0816" => 'indosat', "0855" => 'indosat',
        "0856" => 'indosat', "0857" => 'indosat', "0858" => 'indosat',
        
        "0817" => 'xl', "0818" => 'xl', "0819" => 'xl',
        "0859" => 'xl', "0877" => 'xl', "0878" => 'xl',
        
        "0811" => 'telkomsel', "0812" => 'telkomsel', "0813" => 'telkomsel',
        "0851" => 'telkomsel', "0852" => 'telkomsel', "0853" => 'telkomsel',
        "0821" => 'telkomsel', "0823" => 'telkomsel', "0822" => 'telkomsel',
        
        "0838" => 'axis', "0837" => 'axis',
        "0831" => 'axis', "0832" => 'axis',
        
        "0881" => 'smart', "0882" => 'smart', "0883" => 'smart', 
        "0884" => 'smart', "0885" => 'smart', "0886" => 'smart', 
        "0887" => 'smart', "0888" => 'smart', "0889" => 'smart',

        "0895" => 'three', "0896" => 'three', "0897" => 'three',
        "0898" => 'three', "0899" => 'three',
    ];

    protected function toMobileOperator($phone)
    {
        foreach ($this->operators as $prefix => $operator) {
            if (strpos($phone, $prefix) === 0) {
                return $operator;
            }
        }

        return false;
    }
}