<?php

use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Logjam\RequestId;
use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Logjam\Line;
use LogjamDispatcher\Dispatcher\Expression;
use LogjamDispatcher\Dispatcher\Expression\Severity;

/**
 * Class MessageTest
 * @property Message $instance
 */
class MessageTest extends AbstractMessageTest
{
    /**
     * @return Message
     */
    protected function getMessageInstance()
    {
        $message = new Message();

        return $message;
    }

    /**
     * Test the Action getter/setter
     */
    public function testAction()
    {
        $testAction = 'GET';

        $this->assertSame(null, $this->instance->getAction());
        $this->instance->setAction($testAction);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getAction());
        $this->assertSame($testAction, $this->instance->getAction());
    }

    /**
     * Tests RequestStartedAt getter/setter
     */
    public function testRequestStartedAt()
    {
        $testTimestamp = new DateTime("now", new DateTimeZone("Europe/Berlin"));

        $this->assertSame(null, $this->instance->getRequestStartedAt());
        $this->instance->setRequestStartedAt($testTimestamp);
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestStartedAt());
        $this->assertSame($testTimestamp, $this->instance->getRequestStartedAt());
    }

    /**
     * Tests RequestStartedAt getter/setter with default value
     */
    public function testRequestStartedAtWithDefaultValue()
    {
        $this->assertSame(null, $this->instance->getRequestStartedAt());
        $this->instance->setRequestStartedAt();
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestStartedAt());
    }

    /**
     * Tests RequestEndedAt getter/setter
     */
    public function testRequestEndedAt()
    {
        $testTimestamp = new DateTime("now", new DateTimeZone("Europe/Berlin"));

        $this->assertSame(null, $this->instance->getRequestEndedAt());
        $this->instance->setRequestEndedAt($testTimestamp);
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestEndedAt());
        $this->assertSame($testTimestamp, $this->instance->getRequestEndedAt());
    }

    /**
     * Tests RequestEndedAt getter/setter with default value
     */
    public function testRequestEndedAtWithDefaultValue()
    {
        $this->assertSame(null, $this->instance->getRequestEndedAt());
        $this->instance->setRequestEndedAt();
        $this->assertInstanceOf(DateTime::class, $this->instance->getRequestEndedAt());
    }

    /**
     * Tests ResponseCode getter/setter
     */
    public function testResponseCode()
    {
        $testResponseCode = 404;

        $this->assertSame(null, $this->instance->getResponseCode());
        $this->instance->setResponseCode($testResponseCode);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getResponseCode());
        $this->assertSame($testResponseCode, $this->instance->getResponseCode());
    }

    /**
     * Tests Severity getter/setter
     */
    public function testSeverity()
    {
        $testSeverity = LogjamDispatcher\Dispatcher\Expression\Severity::DEBUG;

        $this->assertSame(\LogjamDispatcher\Dispatcher\Expression\Severity::UNKOWN, $this->instance->getSeverity());
        $this->instance->setSeverity($testSeverity);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getSeverity());
        $this->assertSame($testSeverity, $this->instance->getSeverity());
    }

    /**
     * Tests CallerId getter/setter
     */
    public function testCallerId()
    {
        $testCallerId = 'foobar123';

        $this->assertSame(null, $this->instance->getCallerId());
        $this->instance->setCallerId($testCallerId);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getCallerId());
        $this->assertSame($testCallerId, $this->instance->getCallerId());
    }

    /**
     * Tests CallerAction getter/setter
     */
    public function testCallerAction()
    {
        $testCallerAction = 'foobar123';

        $this->assertSame(null, $this->instance->getCallerAction());
        $this->instance->setCallerAction($testCallerAction);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getCallerAction());
        $this->assertSame($testCallerAction, $this->instance->getCallerAction());
    }

    /**
     * Tests UserId getter/setter
     */
    public function testUserId()
    {
        $testUserId = 700349;

        $this->assertSame(null, $this->instance->getUserId());
        $this->instance->setUserId($testUserId);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getUserId());
        $this->assertSame($testUserId, $this->instance->getUserId());
    }

    /**
     * Tests Host getter/setter
     */
    public function testHost()
    {
        $testHost = 'foo.bar';

        $this->assertSame(null, $this->instance->getHost());
        $this->instance->setHost($testHost);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getHost());
        $this->assertSame($testHost, $this->instance->getHost());
    }

    /**
     * Tests Ip getter/setter
     */
    public function testIp()
    {
        $testIp = '127.0.0.1';

        $this->assertSame(null, $this->instance->getIp());
        $this->instance->setIp($testIp);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getIp());
        $this->assertSame($testIp, $this->instance->getIp());
    }

    /**
     * Tests RequestId getter/setter
     */
    public function testRequestId()
    {
        $testRequestId = new RequestId();

        $this->assertSame(null, $this->instance->getRequestId());
        $this->instance->setRequestId($testRequestId);
        $this->assertInstanceOf(RequestId::class, $this->instance->getRequestId());
        $this->assertSame($testRequestId, $this->instance->getRequestId());
    }

    /**
     * Tests Url getter/setter
     */
    public function testUrl()
    {
        $testUrl = ['my/url/is/foo/bar'];

        $this->assertSame([], $this->instance->getUrl());
        $this->instance->setUrl($testUrl);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getUrl());
        $this->assertSame($testUrl, $this->instance->getUrl());

    }

    /**
     * Tests Exceptions getter/setter
     */
    public function testExceptions()
    {
        $testExceptions = [new \Exception()];

        $this->assertSame([], $this->instance->getExceptions());
        $this->instance->setExceptions($testExceptions);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getExceptions());
        $this->assertSame($testExceptions, $this->instance->getExceptions());
    
        $anotherException = new \Exception('2');
        $this->instance->addException($anotherException);
        $testExceptions[] = $anotherException;
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getExceptions());
        $this->assertSame($testExceptions, $this->instance->getExceptions());
    }

    public function testAdditionalData()
    {
        $testAdditionalData = ["foo" => "bar"];

        $this->assertSame([], $this->instance->getAdditionalData());
        $this->instance->setAdditionalData($testAdditionalData);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getAdditionalData());
        $this->assertSame($testAdditionalData, $this->instance->getAdditionalData());
    }

    /**
     * Tests DbTime getter/setter
     */
    public function testDbTime()
    {
        $testDbTime = 200.12;

        $this->assertSame(null, $this->instance->getDbTime());
        $this->instance->setDbTime($testDbTime);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_FLOAT, $this->instance->getDbTime());
        $this->assertSame($testDbTime, $this->instance->getDbTime());
    }

    /**
     * Tests DbCalls getter/setter
     */
    public function testDbCalls()
    {
        $testDbCalls = 700349;

        $this->assertSame(null, $this->instance->getDbCalls());
        $this->instance->setDbCalls($testDbCalls);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $this->instance->getDbCalls());
        $this->assertSame($testDbCalls, $this->instance->getDbCalls());
    }

    /**
     * Tests Lines getter/setter/add
     */
    public function testLines()
    {
        $testLines = [new Line()];

        $this->assertSame([], $this->instance->getLines());

        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_BOOL, $this->instance->hasLines());
        $this->assertSame(false, $this->instance->hasLines());

        $this->instance->addLine($testLines[0]);
        $this->assertSame(true, $this->instance->hasLines());
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->instance->getLines());
        $this->assertSame($testLines, $this->instance->getLines());
    }
    /**
     * Tests HttpRequestInformation getter/setter
     */
    public function testHttpRequestInformation()
    {
        $testRequestInformation = new RequestInformation();

        $this->assertSame(null, $this->instance->getHttpRequestInformation());
        $this->instance->setRequestInformation($testRequestInformation);
        $this->assertInstanceOf(RequestInformation::class, $this->instance->getHttpRequestInformation());
        $this->assertSame($testRequestInformation, $this->instance->getHttpRequestInformation());
    }

    /**
     * test if the object is serializeable
     */
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

    /**
     * Test if we get the highest severity out of all lines.
     */
    public function testGetHighestSeverity()
    {
        $message = new Message();
        $message->addLine(new Line(Severity::INFO));
        $message->addLine(new Line(Severity::ERROR));
        $message->setSeverityToMax();
        $this->assertEquals(Severity::ERROR, $message->getSeverity(), "not correct high severity");
    }

    /**
     * Test if we get the correct default (highest) severity.
     */
    public function testGetHighestSeverityInCaseOfUnknownSeverity()
    {
        $message = new Message();
        $message->addLine(new Line(Severity::INFO));
        $message->addLine(new Line());
        $message->setSeverityToMax();
        $this->assertEquals(Severity::FATAL, $message->getSeverity(), "not correct high severity for message line with unknown severity");
    }

    /**
     * Test if we get the correct default (highest) severity
     * when there are no lines for whatever reason.
     */
    public function testSeverityOfMessageWithoutLines()
    {
        $message = new Message();
        $this->assertEquals(Severity::UNKOWN, $message->getSeverity(), "not correct severity");
        $message->setSeverityToMax();
        $this->assertEquals(Severity::FATAL, $message->getSeverity(), "high severity wasn't converted correctly");
    }

}