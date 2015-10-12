<?php

namespace LogjamDispatcher\Dispatcher;

use LogjamDispatcher\Message;
use ZMQ;
use ZMQContext;
use ZMQSocket;
use ZMQSocketException;

/**
 * Dispatches a logjam message using ZeroMQ.
 */
class ZmqDispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    protected $brokers = array();
    
    /**
     * @var ZMQSocket
     */
    protected $queue;
    
    /**
     * @var string
     */
    protected $application;    
    
    /**
     * @var string
     */
    protected $environment;
    
    /**
     * @var array
     */
    protected $fieldsToFilter;
    
    /**
     * Indexes to be filtered from requests are replaced with this string.
     * @var string
     */
    protected $filterMask;
    
    /**
     * @var boolean
     */
    protected $isConnected;

    /**
     * ZmqDispatcher constructor.
     * @param array $brokers ZeroMQ Broker addresses (tcp://host:port).
     * @param $application
     * @param string $environment String that identifies the environment the app is in.
     * @param array $fieldsToFilter Array of identifiers in post or get data that should be filtered from the log data.
     * @param string $filterMask String to replace the filtered data with.
     */
    public function __construct(array $brokers, $application, $environment, array $fieldsToFilter = array(), $filterMask = '*****')
    {
        $this->brokers = $brokers;
        $this->environment = $environment;
        $this->fieldsToFilter = $fieldsToFilter;
        $this->filterMask = $filterMask;
        $this->application = $application;
    }
    
    /**
     * Dispatches the message
     * @param Message $message
     */
    public function dispatch(Message $message)
    {
        if ($this->isConnected === null) {
            $this->connect();
        }
        if ($this->isConnected) {
            $logString = $this->messageToArray($message);
            try {
                $this->queue
                    ->sendmulti(
                        array(
                            $this->application . '-' . $this->environment,
                            'logs.' . $this->application . '.' . $this->environment,
                            $logString
                        )
                    );
            } catch (ZMQSocketException $exception) {
                // @todo log to file
            }
        }
    }
    
    /**
     * Returns message data as json.
     *
     * @param Message $message
     * @return array
     */
    protected function messageToArray(Message $message)
    {
        $logArray =  array(
            // required
            'action'        => $message->getAction(),
            'started_at'    => date('c', $message->getRequestStartedTimestamp()), // ISO 8601
            'started_ms'    => $message->getRequestStartedTimestampInMilliseconds(),
            'total_time'    => round($message->getTotalTime(), 5),
            'code'          => $message->getResponseCode(),
            'severity'      => $message->getSeverity(),
            'caller_id'     => $message->getCallerId(),
            'caller_action' => $message->getCallerAction(),
            'user_id'       => $message->getUserId(),
            'host'          => $message->getHost(),
            'ip'            => $message->getIp(),
            'request_id'    => uniqid('', true),
            'request_info'   => array(
                'query_parameters' => $this->filterPrivateFields($message->getQueryParameters()),
                'headers'          => $message->getHeaders(),
                'url'               => $message->getUrl(),
                'method'           => $message->getMethod(),
                'body_parameters'  => $this->filterPrivateFields($message->getBodyParameters()),
            ),
            'exceptions'     => $message->getExceptions(),
            'message'         => $message->getAdditionalData()
        );
        
        if ($message->getDbCalls() !== null) {
            $logArray['db_calls'] = $message->getDbCalls();
        }

        if ($message->getDbTime() !== null) {
            $logArray['db_time'] = $message->getDbTime();
		}

        if (count($message->getLines()) > 0) {
            $logArray['lines'] = $message->getLines();
        }

        return json_encode($logArray);
    }    
    
    /**
     * Connect to the zeromq channel.‚
     */
    protected function connect()
    {
        if ($this->setupSocket()) {
            foreach($this->brokers as $broker) {
                try {
                    $this->queue->connect($broker);
                    $this->isConnected = true;
                } catch (ZMQSocketException $exception) {
                    // we cannot connect, make sure application does not exit
                    // @todo log this into a file
                }
            }
        } else {
            $this->isConnected = false;
        }
    }
    
    /**
     * Tries to setup a ZeroMQ-Socket.
     * @return bool
     */
    protected function setupSocket()
    {
        $successful = false;
        try {
            $this->queue = new ZMQSocket(new ZMQContext(), ZMQ::SOCKET_PUSH);
            $successful = true;
        } catch(ZMQSocketException $exception) {
            // @todo log this into a file
        }
        
        return $successful;
    }
    
    /**
     * Filter private fields that should not be shown in logs.
     *
     * @param array $unfilteredFields
     * @return array
     */
    protected function filterPrivateFields(array $unfilteredFields)
    {
        foreach($this->fieldsToFilter as $fieldToFilter) {
            if (array_key_exists($fieldToFilter, $unfilteredFields)) {
                $unfilteredFields[$fieldToFilter] = $this->filterMask;
            }
        }
        
        return $unfilteredFields;
    }    
    
}
