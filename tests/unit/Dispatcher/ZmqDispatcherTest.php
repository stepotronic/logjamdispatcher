<?php

use LogjamDispatcher\Dispatcher\ZmqDispatcher;
use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Logjam\RequestId;
use LogjamDispatcher\Dispatcher\Expression;

/**
 * Class ZmqDispatcherTest
 * @property ZmqDispatcher $instance
 */
class ZmqDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message
     */
    protected $message;
    
    public function setUp()
    {
        $this->message = new Message();
        
        $fakeStartTime = new DateTime("now", new DateTimeZone("Europe/Berlin"));

        $requestInformation = new RequestInformation();
        $requestInformation
            ->setMethod('GET')
            ->setHeaders(['Accept' => 'Nothing', 'Feels' => 'BadMan'])
            ->setBodyParameters(['action' => 'submit'])
            ->setQueryParameters(['page' => '15', 'offset' => '213123'])
            ->setUrl('my.app.page/products');


        $this->message
            ->setAction('MyApp::MyController#MyAction')
            ->setAdditionalData(['stuff' => 'theUserDid'])
            ->setCallerAction('') //value of http request header X-Logjam-Action (if present)
            ->setCallerId('')     //value of http request header X-Logjam-Caller-Id (if present)
            ->setDbCalls(12)
            ->setDbTime(123123.123)
            ->setExceptions([new \Exception("Test Exception")])
            ->setHost('my.app.host')
            ->setIp('123.321.123.321')
            ->setRequestId(new RequestId())
            ->setRequestInformation($requestInformation)
            ->setRequestStartedAt($fakeStartTime)
            ->setResponseCode(200)
            ->setSeverity(Expression\Severity::INFO)
            ->setRequestEndedAt($fakeStartTime)
            ->setUserId(0);
    }
    
    public function testException()
    {
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();
        
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $dispatcher->hasExceptions());
        $this->assertSame(false, $dispatcher->hasExceptions());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $dispatcher->getExceptions());

        $zmqSocketMock->method('connect')->willThrowException(new ZMQSocketException("Mock Exception for connection fail."));
        $dispatcher->dispatch($this->message);
        
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $dispatcher->hasExceptions());
        $this->assertSame(true, $dispatcher->hasExceptions());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $dispatcher->getExceptions());
        $this->assertGreaterThanOrEqual(1, $dispatcher->getExceptions());
    }
    
    public function testZMQSocketFactory() {
        $this->assertInstanceOf(ZMQSocket::class, ZmqDispatcher::createZmqSocket());
    }
    
    public function testConstructorCreatesSocketInstanceWithoutExceptions()
    {
        new ZmqDispatcher(['tcp://willneverconnect'], 'testapp', 'testenv');
    }
    
    public function testConnectFails()
    {
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();

        $zmqSocketMock->method('connect')->willThrowException(new ZMQSocketException("Mock Exception for connection fail."));
        $dispatcher->dispatch($this->message);
        $this->assertEquals(true, $dispatcher->hasExceptions());
    }
    
    public function testConnectWorks()
    {
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();

        $dispatcher->dispatch($this->message);
        $this->assertEquals(false, $dispatcher->hasExceptions());
    }
    
    public function testDispatch()
    {
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();
        
        $dispatcher->dispatch($this->message);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $dispatcher->hasExceptions());
        $this->assertSame(false, $dispatcher->hasExceptions());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $dispatcher->getExceptions());
    }


    public function testDispatchFailesWithInvalidMEssage()
    {
        $exceptionName = \LogjamDispatcher\Exception\ValidationException::class;
        $this->setExpectedException($exceptionName);
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();
        $message = clone  $this->message;
        $message->setAction(123);
        $dispatcher->dispatch($message);
        
        if(!$dispatcher->hasExceptions()) {
            $this->fail(sprintf('Expected missformated message to cause an "%s" Exception.', $exceptionName));
        } else {
            foreach($dispatcher->getExceptions() as $e) {
                throw $e;
            }
        }
        
    }
    
    public function testDispatchFailesToSendMulti()
    {
        /**
         * @var ZmqDispatcher $dispatcher
         * @var PHPUnit_Framework_MockObject_MockObject $zmqSocketMock
         */
        list($dispatcher, $zmqSocketMock) = $this->getDispatcherInstance();
        
        $zmqSocketMock->method('sendmulti')->willThrowException(new ZMQSocketException("Mock Exception for sendmulti fail"));
        $dispatcher->dispatch($this->message);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $dispatcher->hasExceptions());
        $this->assertSame(true, $dispatcher->hasExceptions());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $dispatcher->getExceptions());
        $this->assertGreaterThanOrEqual(1, $dispatcher->getExceptions());
    }
    
    /**
     * @return array
     */
    protected function getDispatcherInstance()
    {
        /**
         * @var $zmqSocketMock ZMQSocket
         */
        $zmqSocketMock = $this->getZMQSocketMock();
        
        $dispatcher = new ZmqDispatcher(['tcp://willneverconnect'], 'testapp', 'testenv', $zmqSocketMock);

        return [$dispatcher, $zmqSocketMock];
    }

    /**
     * Prepares a mock for ZMQSocket with connect and sendmulti methods
     * 
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getZMQSocketMock()
    {
        $ZMQSocketMock = $this->getMock('ZMQSocket', [
            'connect',
            'sendmulti',
        ], [], '', false);
        
        $ZMQSocketMock->method('connect')->willReturn(true);
        
        return $ZMQSocketMock;
    }
}
