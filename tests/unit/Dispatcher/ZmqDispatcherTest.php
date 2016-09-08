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
            ->setHeaders(array('Accept' => 'Nothing', 'Feels' => 'BadMan'))
            ->setBodyParameters(array('action' => 'submit'))
            ->setQueryParameters(array('page' => '15', 'offset' => '213123'))
            ->setUrl('my.app.page/products');


        $this->message
            ->setAction('MyApp::MyController#MyAction')
            ->setAdditionalData(array('stuff' => 'theUserDid'))
            ->setCallerAction('') //value of http request header X-Logjam-Action (if present)
            ->setCallerId('')     //value of http request header X-Logjam-Caller-Id (if present)
            ->setDbCalls(12)
            ->setDbTime(123123.123)
            ->setExceptions(array(new \Exception("Test Exception")))
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
        $zmqSocketMock = $this->getZMQSocketMock();
        $dispatcher = new ZmqDispatcher($zmqSocketMock, array('tcp://willneverconnect'), 'testapp', 'testenv');

        return [$dispatcher, $zmqSocketMock];
    }
    
    protected function getZMQSocketMock()
    {
        $ZMQSocketMock = $this->getMock('ZMQSocket', array(
            'connect',
            'sendmulti',
        ), array(), '', false);
        
        $ZMQSocketMock->method('connect')->willReturn(true);
        
        return $ZMQSocketMock;
    }
}