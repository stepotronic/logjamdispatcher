<?php

use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Logjam\RequestId;
use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Logjam\Line;
use LogjamDispatcher\Dispatcher\Expression;

/**
 * Class MessageTest
 * @property Message $instance
 */
class MessageTest extends AbstractMessageTest
{
    protected function getMessageInstance()
    {
        $message = new Message();

        return $message;
    }

    public function testAction()
    {
        $testAction = 'GET';

        $this->assertSame(null, $this->instance->getAction());
        $this->instance->setAction($testAction);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getAction());
        $this->assertSame($testAction, $this->instance->getAction());
    }

    public function testRequestStartedAt()
    {
        $testTimestamp = new DateTime("now", new DateTimeZone("Europe/Berlin"));

        $this->assertSame(null, $this->instance->getRequestStartedAt());
        $this->instance->setRequestStartedAt($testTimestamp);
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestStartedAt());
        $this->assertSame($testTimestamp, $this->instance->getRequestStartedAt());
    }

    public function testRequestEndedAt()
    {
        $testTimestamp = new DateTime("now", new DateTimeZone("Europe/Berlin"));

        $this->assertSame(null, $this->instance->getRequestEndedAt());
        $this->instance->setRequestEndedAt($testTimestamp);
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestEndedAt());
        $this->assertSame($testTimestamp, $this->instance->getRequestEndedAt());
    }

    public function testResponseCode()
    {
        $testResponseCode = 404;

        $this->assertSame(null, $this->instance->getResponseCode());
        $this->instance->setResponseCode($testResponseCode);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getResponseCode());
        $this->assertSame($testResponseCode, $this->instance->getResponseCode());
    }

    public function testSeverity()
    {
        $testSeverity = LogjamDispatcher\Dispatcher\Expression\Severity::DEBUG;

        $this->assertSame(\LogjamDispatcher\Dispatcher\Expression\Severity::UNKOWN, $this->instance->getSeverity());
        $this->instance->setSeverity($testSeverity);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getSeverity());
        $this->assertSame($testSeverity, $this->instance->getSeverity());
    }

    public function testCallerId()
    {
        $testCallerId = 'foobar123';

        $this->assertSame(null, $this->instance->getCallerId());
        $this->instance->setCallerId($testCallerId);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getCallerId());
        $this->assertSame($testCallerId, $this->instance->getCallerId());
    }

    public function testCallerAction()
    {
        $testCallerAction = 'foobar123';

        $this->assertSame(null, $this->instance->getCallerAction());
        $this->instance->setCallerAction($testCallerAction);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getCallerAction());
        $this->assertSame($testCallerAction, $this->instance->getCallerAction());
    }

    public function testUserId()
    {
        $testUserId = 700349;

        $this->assertSame(null, $this->instance->getUserId());
        $this->instance->setUserId($testUserId);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getUserId());
        $this->assertSame($testUserId, $this->instance->getUserId());
    }

    public function testHost()
    {
        $testHost = 'foo.bar';

        $this->assertSame(null, $this->instance->getHost());
        $this->instance->setHost($testHost);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getHost());
        $this->assertSame($testHost, $this->instance->getHost());
    }

    public function testIp()
    {
        $testIp = '127.0.0.1';

        $this->assertSame(null, $this->instance->getIp());
        $this->instance->setIp($testIp);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getIp());
        $this->assertSame($testIp, $this->instance->getIp());
    }

    public function testRequestId()
    {
        $testRequestId = new RequestId();

        $this->assertSame(null, $this->instance->getRequestId());
        $this->instance->setRequestId($testRequestId);
        $this->assertInstanceOf(RequestId::class, $this->instance->getRequestId());
        $this->assertSame($testRequestId, $this->instance->getRequestId());
    }

    public function testUrl()
    {
        $testUrl = array('my/url/is/foo/bar');

        $this->assertSame(array(), $this->instance->getUrl());
        $this->instance->setUrl($testUrl);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getUrl());
        $this->assertSame($testUrl, $this->instance->getUrl());

    }

    public function testExceptions()
    {
        $testExceptions = array(new \Exception());

        $this->assertSame(array(), $this->instance->getExceptions());
        $this->instance->setExceptions($testExceptions);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getExceptions());
        $this->assertSame($testExceptions, $this->instance->getExceptions());
    }

    public function testAdditionalData()
    {
        $testAdditionalData = array("foo" => "bar");

        $this->assertSame(array(), $this->instance->getAdditionalData());
        $this->instance->setAdditionalData($testAdditionalData);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getAdditionalData());
        $this->assertSame($testAdditionalData, $this->instance->getAdditionalData());
    }

    public function testDbTime()
    {
        $testDbTime = 200.12;

        $this->assertSame(null, $this->instance->getDbTime());
        $this->instance->setDbTime($testDbTime);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_FLOAT, $this->instance->getDbTime());
        $this->assertSame($testDbTime, $this->instance->getDbTime());
    }

    public function testDbCalls()
    {
        $testDbCalls = 700349;

        $this->assertSame(null, $this->instance->getDbCalls());
        $this->instance->setDbCalls($testDbCalls);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getDbCalls());
        $this->assertSame($testDbCalls, $this->instance->getDbCalls());
    }

    public function testLines()
    {
        $testLines = array(new Line());

        $this->assertSame(array(), $this->instance->getLines());

        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $this->instance->hasLines());
        $this->assertSame(false, $this->instance->hasLines());

        $this->instance->addLine($testLines[0]);
        $this->assertSame(true, $this->instance->hasLines());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getLines());
        $this->assertSame($testLines, $this->instance->getLines());
    }

    public function testHttpRequestInformation()
    {
        $testRequestInformation = new RequestInformation();

        $this->assertSame(null, $this->instance->getHttpRequestInformation());
        $this->instance->setRequestInformation($testRequestInformation);
        $this->assertInstanceOf(RequestInformation::class, $this->instance->getHttpRequestInformation());
        $this->assertSame($testRequestInformation, $this->instance->getHttpRequestInformation());
    }

    public function testObjectIsJsonSerializable()
    {
        $this->instance->setRequestInformation(new RequestInformation());
        $this->instance->setRequestId(new RequestId());
        $this->instance->setDbTime(100.200);
        $this->instance->setDbCalls(12);
        $this->instance->setRequestStartedAt(new DateTime("now", new DateTimeZone("Europe/Berlin")));
        $this->instance->setRequestEndedAt(new DateTime("now", new DateTimeZone("Europe/Berlin")));
        
        $this->instance->addLine(new Line(Expression\Severity::ERROR, "Fatal Foo Bar", new DateTime("2016-08-01T03:33:03.541352", new DateTimeZone("Europe/Berlin"))));

        json_encode($this->instance);
    }
}