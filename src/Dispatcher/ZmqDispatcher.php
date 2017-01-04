<?php

namespace LogjamDispatcher\Dispatcher;

use LogjamDispatcher\Logjam\MessageInterface;
use LogjamDispatcher\Validator\MessageValidator;

use LogjamDispatcher\Exception\LogjamDispatcherException;

use ZMQ;
use ZMQSocket;
use ZMQContext;
use ZMQException;
use ZMQSocketException;

/**
 * Dispatches a logjam message using ZeroMQ.
 */
class ZmqDispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    protected $brokers = [];
    
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
    protected $exceptions = [];

    /**
     * ZmqDispatcher constructor.
     * 
     * @param array $brokers ZeroMQ Broker addresses (tcp://host:port).
     * @param string $application
     * @param string $environment String that identifies the environment the app is in.
     * @param ZMQSocket $socket
     */
    public function __construct(array $brokers, $application, $environment, ZMQSocket $socket = null)
    {
        if (null === $socket) {
            $socket = self::createZmqSocket();
        }
        
        $this->queue = $socket;
        $this->brokers = $brokers;
        $this->environment = $environment;
        $this->application = $application;
    }
    

    /**
     * Dispatches the message
     * @param MessageInterface $message
     * 
     * @return boolean
     */
    public function dispatch(MessageInterface $message)
    {
        $this->exceptions = [];


        if($this->connect()) {
            return $this->sendMessage($message);
        }
       
       return false;
    }
    
    /**
     * Connect to the zeromq channel.‚
     */
    protected function connect()
    {
        if(null === $this->isConnected) {
            foreach($this->brokers as $broker) {
                try {
                    $this->queue->connect($broker);
                    $this->isConnected = true;
                    break;
                } catch (ZMQSocketException $exception) {
                    // we cannot connect, make sure application does not exit
                    $this->addDispatchException($exception);
                    $this->isConnected = false;
                }
            }
        }
        
        return $this->isConnected();
    }

    /**
     * @return boolean
     */
    public function isConnected()
    {
        return $this->isConnected;
    }

    
    /**
     * Factory method for a ZMQSocket
     * 
     * @param  ZMQContext|null $context
     * @param  int $socketType
     * 
     * @return ZMQSocket
     * 
     * @throws ZMQSocketException
     */
    public static function createZmqSocket(ZMQContext $context = null, $socketType = ZMQ::SOCKET_PUSH)
    {
        if ($context === null) {
            $context = new ZMQContext();
        }
        
        return new ZMQSocket($context, $socketType);
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

    /**
     * Sends message if it's valid. Return false on failure
     * 
     * @param MessageInterface $message
     * @param string           $tag
     * 
     * @return bool
     */
    protected function sendMessage(MessageInterface $message, $tag = '')
    {
        try {
            MessageValidator::validate($message);
            
            $this->queue->sendmulti([
                $this->application . '-' . $this->environment,
                'logs.' . $this->application . '.' . $this->environment,
                json_encode($message),
                $tag
            ]);

            $sent = true;
        } catch (ZMQSocketException $exception) {
            // we cannot connect, make sure application does not exit
            $this->addDispatchException($exception);

            $sent = false;
        } catch (LogjamDispatcherException $e) {
            $this->addDispatchException($e);

            $sent = false;
        }

        return $sent;
    }
}
