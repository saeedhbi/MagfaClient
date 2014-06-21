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
    public function connect()
    {
        if (empty($this->connection)) {
            try {
                $params = array(
                    'login' => $this->datasets['username'],
                    'password' => $this->datasets['password'], // Credientials
                    'features' => SOAP_USE_XSI_ARRAY_TYPE // Required
                                );
                $this->connection = new SoapClient($this->datasets['wsdl'], $params);
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
            $s = $this->connect()->__soapCall('enqueue', array(
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
     * Send request to specified provider
     *
     * @param string $method            
     * @return mixed
     */
    public function request($method)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}();
        } else
            throw new MagfaSOAPException('Method is not exist.');
    }

    /**
     * Class to getCredit from provider
     *
     * @return object
     */
    public function getCredit()
    {
        try {
            $s = $this->connect()->__soapCall('getCredit', array(
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
            $s = $this->connect()->__soapCall('getAllMessages', array(
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
            $s = $this->connect()->__soapCall('getAllMessagesWithNumber', array(
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
            $s = $this->connect()->__soapCall('getMessageId', array(
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
            $s = $this->connect()->__soapCall('getMessageStatus', array(
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
            $s = $this->connect()->__soapCall('getMessageStatuses', array(
                'messageId' => $this->datasets['messageId']
            ));
            
            return $s;
        } catch (SoapFault $e) {
            throw new MagfaSOAPException($e->faultstring, 401);
        }
    }
}
