<?php
namespace MagfaClient;

use SoapClient;

class MagfaClient
{
    public function __construct($wsdl){
        $this->connect($wsdl);
    }
    
    public function connect($wsdl){
        return new SoapClient($wsdl); 
    }
}
