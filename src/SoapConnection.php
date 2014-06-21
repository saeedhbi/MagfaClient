<?php
namespace MagfaClient;

use Exceptions\AsanakSOAPException;
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
                throw new AsanakSOAPException($e->faultstring, 401);
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
            $s = $this->connection->sendSms(array(
                'userCredential' => array(
                    'username' => $this->datasets['username'],
                    'password' => $this->datasets['password']
                ),
                'srcAddresses' => $this->datasets['srcAddresses'],
                'destAddresses' => $this->datasets['destAddresses'],
                'msgBody' => $this->datasets['msgBody'],
                'msgEncoding' => $this->datasets['msgEncoding']
            ));
            return $s;
        } catch (SoapFault $e) {
            throw new AsanakSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getReportByMsgId from provider
     *
     * @return object
     */
    public function getReportByMsgId()
    {
        try {
            $s = $this->connection->getReportByMsgId(array(
                'userCredential' => array(
                    'username' => $this->datasets['username'],
                    'password' => $this->datasets['password']
                ),
                'msgIds' => $this->datasets['msgIds']
            ));
            return $s;
        } catch (SoapFault $e) {
            throw new AsanakSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getReceivedMsg from provider
     *
     * @return object
     */
    public function getReceivedMsg()
    {
        try {
            $s = $this->connection->getReceivedMsg(array(
                'userCredential' => array(
                    'username' => $this->datasets['username'],
                    'password' => $this->datasets['password']
                ),
                'wsdl' => $this->datasets['wsdl'],
                'srcAddresses' => $this->datasets['srcAddresses'],
                'destAddresses' => $this->datasets['destAddresses'],
                'maxReturnedMsg' => $this->datasets['maxReturnedMsg'],
                'fromTime' => $this->datasets['fromTime']
            ));
            return $s;
        } catch (SoapFault $e) {
            throw new AsanakSOAPException($e->faultstring, 401);
        }
    }

    /**
     * Class to getUserCredit from provider
     *
     * @return object
     */
    public function getUserCredit()
    {
        try {
            $s = $this->connection->getUserCredit(array(
                'userCredential' => array(
                    'username' => $this->datasets['username'],
                    'password' => $this->datasets['password']
                ),
                'wsdl' => $this->datasets['wsdl']
            ));
            return $s;
        } catch (SoapFault $e) {
            throw new AsanakSOAPException($e->faultstring, 401);
        }
    }
}
