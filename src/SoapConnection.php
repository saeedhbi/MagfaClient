<?php
namespace MagfaClient;

use Exceptions\MagfaSOAPException;
use ConnectionInterface;

class SoapConnection implements ConnectionInterface
{

    /**
     * Dataset overload data
     *
     * @var array
     */
    private $datasets = array();

    /**
     * Connection property to return instance.
     */
    private $connection;

    /**
     * Set values to properties
     *
     * @param array $values            
     *
     * @return void
     */
    public function __construct($values)
    {
        $this->datasets = $values;
    }

    /**
     * Class to connect connection
     *
     * @return object
     */
    public function connect($connect)
    {
        if (empty($this->connection)) {
            try {
                $params = array(
                    'login' => $connect['username'],
                    'password' => $connect['password'], // Credientials
                    'features' => SOAP_USE_XSI_ARRAY_TYPE // Required
                                );
                $this->connection = new SoapClient($connect['wsdl'], $params);
            } catch (SoapFault $e) {
                throw new MagfaSOAPException($e->faultstring, 401);
            }
        }
        return $this->connection;
    }

    /**
     * Class to send values to provider
     *
     * @return object
     */
    public function sendSms()
    {
        try {
            $s = $this->connection->__soapCall('enqueue', array(
                'domain' => $this->datasets['domain'],
                'messageBodies' => array(
                    $this->datasets['messageBodies']
                ),
                'recipientNumbers' => $this->datasets['recipientNumbers'],
                'senderNumbers' => array(
                    $this->datasets['senderNumbers']
                )
            ));
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getCredit from provider
     *
     * @return object
     */
    public function getCredit()
    {
        try {
            $s = $this->connection->__soapCall('getCredit', array(
                'domain' => $this->datasets['domain']
            ));
            
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getAllMessages from provider
     *
     * @return object
     */
    public function getAllMessages()
    {
        try {
            $s = $this->connection->__soapCall('getAllMessages', array(
                'domain' => $this->datasets['domain'],
                'numberOfMessasges' => $this->datasets['numberOfMessasges']
            ));
            
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getAllMessagesWithNumber from provider
     *
     * @return object
     */
    public function getAllMessagesWithNumber()
    {
        try {
            $s = $this->connection->__soapCall('getAllMessagesWithNumber', array(
                'domain' => $this->datasets['domain'],
                'numberOfMessasges' => $this->datasets['numberOfMessasges'],
                'destNumber' => $this->datasets['destNumber']
            ));
            
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }
    
    /**
     * Class to getMessageId from provider
     *
     * @return object
     */
    public function getMessageId()
    {
        try {
            $s = $this->connection->__soapCall('getMessageId', array(
                'domain' => $this->datasets['domain'],
                'checkingMessageId' => $this->datasets['checkingMessageId']
            ));
    
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }
    
    /**
     * Class to getMessageStatus from provider
     *
     * @return object
     */
    public function getMessageStatus()
    {
        try {
            $s = $this->connection->__soapCall('getMessageStatus', array(
                'messageId' => $this->datasets['messageId']               
            ));
    
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }
    
    /**
     * Class to getMessageStatuses from provider
     *
     * @return object
     */
    public function getMessageStatuses()
    {
        try {
            $s = $this->connection->__soapCall('getMessageStatuses', array(
                'messageId' => $this->datasets['messageId']               
            ));
    
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }
}
