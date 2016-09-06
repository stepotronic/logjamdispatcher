<?php

namespace LogjamDispatcher\Dispatcher;

use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Logjam\MessageInterface;
use LogjamDispatcher\Logjam\RequestId;
use LogjamDispatcher\Validator\MessageValidator;

use LogjamDispatcher\Exception\LogjamDispatcherException;

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
     * @var boolean
     */
    protected $isConnected;

    /**
     * @var array
     */
    protected $exceptions = array();

    /**
     * ZmqDispatcher constructor.
     * @param array $brokers ZeroMQ Broker addresses (tcp://host:port).
     * @param $application
     * @param string $environment String that identifies the environment the app is in.
     * @param array $fieldsToFilter Array of identifiers in post or get data that should be filtered from the log data.
     * @param string $filterMask String to replace the filtered data with.
     */
    public function __construct(array $brokers, $application, $environment)
    {
        $this->brokers = $brokers;
        $this->environment = $environment;
        $this->application = $application;
    }
    
    /**
     * Dispatches the message
     * @param MessageInterface $message
     * @return boolean
     */
    public function dispatch(MessageInterface $message)
    {
        if ($this->isConnected === null) {
            $this->connect();
        }

        try {
            if (!$this->isConnected) {
                throw new LogjamDispatcherException("Unable to connect to ZMQ.");
            }
            
            MessageValidator::validate($message);

            $this->queue->sendmulti(array(
                $this->application . '-' . $this->environment,
                'logs.' . $this->application . '.' . $this->environment,
                json_encode($message)
            ));
            
        } catch (ZMQSocketException $exception) {
            // Catch ZeroMQ Exceptions
            $this->addDispatchException($exception);

            return false;
        } catch (LogjamDispatcherException $exception) {
            // Catch self thrown Exceptions to avoid recursions
            $this->addDispatchException($exception);

            return false;
        }
        
        return true;
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
                    $this->addDispatchException($exception);
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
            $this->addDispatchException($exception);
        }
        
        return $successful;
    }

    /**
     * @param \Exception $exception
     */
    protected function addDispatchException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    /**
     * @return bool
     */
    public function hasExceptions()
    {
        return count($this->exceptions) > 0;
    }

    /**
     * @return \Exception[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
