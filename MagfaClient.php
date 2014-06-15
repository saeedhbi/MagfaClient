<?php
namespace MagfaClient;

use SoapClient;

class MagfaClient
{
    public $connection;
    
    public function __construct($wsdl){
        $this->connection = $this->connect($wsdl);
    }
    
    public function connect($wsdl, $login){
        return new SoapClient($wsdl, $login);  
    }
    
    public function enqueue($params){ 
        $params = array(
            'domain'=>$this->datasets['domain'],
            'messageBodies'=>$this->datasets['messageBodies'],
            'recipientNumbers'=>$this->datasets['recipientNumbers'],
            'senderNumbers'=>$this->datasets['30004866000006']
        );
        return $result = $this->connection->__soapCall('enqueue', $params);
    }
}
