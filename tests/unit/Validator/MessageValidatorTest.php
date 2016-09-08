<?php

use LogjamDispatcher\Validator\MessageValidator;
use LogjamDispatcher\Logjam\Message;
use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Dispatcher\Expression;
use LogjamDispatcher\Logjam\RequestId;
use LogjamDispatcher\Exception\ValidationException;
use LogjamDispatcher\Logjam\LineInterface;
use LogjamDispatcher\Logjam\Line;


class MessageValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * Sets the test up. Prepares a valid fake message
     */
    protected function setUp()
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

    /**
     * First of all test if the validator do not throws exception if the message is ok
     */
    public function testValidate()
    {
        try {
            MessageValidator::validate($this->message);
        } catch(\Exception $e) {
            $this->fail('Validation throws Error on a valid message.');
        }
    }

    /**
     * Test if the validation only takes valid strings
     * 
     * @throws ValidationException
     */
    public function testValidateActionOnlyAcceptRegex()
    {
        $this->setExpectedException(ValidationException::class);
        MessageValidator::validateAction("wrongformat.nothing");
    }

    /**
     * Tests if the validateAction method only accept string
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateActionThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
            MessageValidator::validateAction($sampleType);
        } else {
            MessageValidator::validateAction('MyApp::MyController#MyAction');
        }
        
    }

    /**
     * Tests if the validateRequestStartedTimestamp method only accept integer
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateRequestStartedTimestampThrowingTypeErrors($sampleType)
    {
        if (!is_int($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "integer", gettype($sampleType)));
        }
        MessageValidator::validateRequestStartedTimestamp($sampleType);
    }

    /**
     * Tests if the validateTotalTime only method accept float
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateTotalTimeThrowingTypeErrors($sampleType)
    {
        if (!is_float($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "float", gettype($sampleType)));
        }
        MessageValidator::validateTotalTime($sampleType);
    }

    /**
     * Tests if the validateResponseCode method only accept int
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateResponseCodeThrowingTypeErrors($sampleType)
    {
        if (!is_int($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "integer", gettype($sampleType)));
        }
        MessageValidator::validateResponseCode($sampleType);
    }

    /**
     * Makes sure that the method throws an ValidationException if the given integer is not a valid HTTP code.
     * @param $code
     */
    public function testValidateResponseCodeThrowsErrorOnNoneHttpCode()
    {
        $code = 12;
        $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::HTTP_CODE_ERROR, $code));
        MessageValidator::validateResponseCode($code);
    }
    
    /**
     * Tests if the validateSeverity method only accept int
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateSeverityThrowingTypeErrors($sampleType)
    {
        if (!is_int($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "integer", gettype($sampleType)));
            MessageValidator::validateSeverity($sampleType);
        }else {
            MessageValidator::validateSeverity(Expression\Severity::DEBUG);
        }
    }

    /**
     * @param int $severity
     * @dataProvider severityProvider
     */
    public function testValidationSeverityThrowingInvalidSeverityErrors($severity)
    {
        if (!in_array($severity, Expression\Severity::$all)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::SEVERITY_ERROR, implode(', ', Expression\Severity::$all)));
        }
        MessageValidator::validateSeverity($severity);
    }

    /**
     * Tests if the validateCallerId method only accept string
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateCallerIdThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
        }
        MessageValidator::validateCallerId($sampleType);
    }

    /**
     * Tests if the validateCallerAction method only accept string
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateCallerActionThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
        }
        MessageValidator::validateCallerAction($sampleType);
    }
    
    /**
     * Tests if the validateUserId method only accept string
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateUserIdThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
        }
        MessageValidator::validateUserId($sampleType);
    }
    
    /**
     * Tests if the validateHost method only accept string
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateHostThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
        }
        MessageValidator::validateHost($sampleType);
    }

    /**
     * Tests if the validateIp method only accept string
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateIpThrowingTypeErrors($sampleType)
    {
        if (!is_string($sampleType)) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "string", gettype($sampleType)));
        }
        MessageValidator::validateIp($sampleType);
    }

    /**
     * @param array   $sampleExceptions
     * @param boolean $isValid
     * @dataProvider exceptionsDataProvider
     */
    public function testValidateExceptionsOnlyAcceptsExceptionArray($sampleExceptions, $isValid)
    {
        if (!$isValid) {
            $this->setExpectedException(ValidationException::class, MessageValidator::EXCEPTIONS_ERROR);
        }
        
        MessageValidator::validateExceptions($sampleExceptions);
    }

    /**
     * @param $sampleAdditionalData
     * @param $depth
     * @dataProvider additionalDataProvider
     */
    public function testValidateAdditionalDataOnlyExceptOneLevelArrays($sampleAdditionalData, $depth)
    {
        if ($depth > 1) {
            $this->setExpectedException(ValidationException::class, MessageValidator::ADDITIONAL_DATA_ERROR);
        }

        MessageValidator::validateAdditionalData($sampleAdditionalData);
    }

    /**
     * Tests if the validateDbCalls method only accept integer
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateDbCallsThrowingTypeErrors($sampleType)
    {
        if (!is_int($sampleType) && $sampleType !== null) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "integer", gettype($sampleType)));
        }
        MessageValidator::validateDbCalls($sampleType);
    }

    /**
     * Tests if the validateDbTime method only accept float
     * @param  mixed $sampleType
     * @throws ValidationException
     * @dataProvider typeProvider
     */
    public function testValidateDbTimeThrowingTypeErrors($sampleType)
    {
        if (!is_float($sampleType) && $sampleType !== null) {
            $this->setExpectedException(ValidationException::class, sprintf(MessageValidator::TYPE_ERROR, "float", gettype($sampleType)));
        }
        MessageValidator::validateDbTime($sampleType);
    }
    
    /**
     * @param array   $sampleExceptions
     * @param boolean $isValid
     * @dataProvider linesProvider
     */
    public function testValidateLinesOnlyAcceptsLinesArray($sampleExceptions, $isValid)
    {
        if (!$isValid) {
            $this->setExpectedExceptionRegExp(ValidationException::class, '/' . str_replace('\\', '\\\\', LineInterface::class) . '/');
        }
        MessageValidator::validateLines($sampleExceptions);
    }

    /**
     * Check if the validate Request Id method does not accept null
     * @throws ValidationException
     */
    public function testValidateRequestIdMethodDoesNotExceptNull()
    {
        $this->setExpectedException(ValidationException::class, MessageValidator::REQUEST_ID_NULL_EXCEPTION);
        MessageValidator::validateRequestId(null);
    }

    /**
     * Check if the validate Request Information method does not accept null
     * @throws ValidationException
     */
    public function testValidateHttpRequestInformationMethodDoesNotExceptNull()
    {
        $this->setExpectedException(ValidationException::class, MessageValidator::REQUEST_INFORMATION_NULL_EXCEPTION);
        MessageValidator::validateHttpRequestInformation(null);
    }

    /**
     * Check if the validate Request Id method does accept RequestInformation
     * @throws ValidationException
     */
    public function testValidateRequestIdMethodDoesExceptRequestID()
    {
        MessageValidator::validateRequestId(new RequestId());
    }

    /**
     * Check if the validate Request Information method does accept RequestInformation
     * @throws ValidationException
     */
    public function testValidateHttpRequestInformationMethodDoesExceptRequestInformation()
    {
        MessageValidator::validateHttpRequestInformation(new RequestInformation());
    }
    
    /**
     * Provides set of additional data example with array depth as second parameter
     * @return array
     */
    public function additionalDataProvider()
    {
        return [
            [[1, 2, 3, 4], 1],
            [[[1, 2], 3, 4], 2],
            [[[[1], 2], 3, 4], 3],
        ];
    }
    
    /**
     * Provides a list of valid and invalid severities
     * @return array
     */
    public function severityProvider()
    {
        return [
            [Expression\Severity::INFO],
            [Expression\Severity::DEBUG],
            [Expression\Severity::ERROR],
            [Expression\Severity::FATAL],
            [Expression\Severity::UNKOWN],
            [Expression\Severity::WARN],
            [9999],
            [-9999],
        ];
    }

    /**
     * Provides each PHP Type
     * @return array
     */
    public function typeProvider()
    {
        return [
            [123], //int
            [123.123], // float
            [false], // boolean
            ['123'], //string
            [['test']], // array
            [new stdClass()], // object
            [null], // NULL
            [function(){ return true; }], // Callback
            [fopen(__FILE__, "r")], // resource
        ];
    }
    
    /**
     * Provides valid and invalid Exception data
     * @return array
     */
    public function exceptionsDataProvider()
    {
        return [
            [[new \Exception("foobar"), new \Exception("foobar")], true],
            [[new \Exception("foobar"), new stdClass()], false],
            [[new stdClass(), new stdClass()], false],
        ];
    }

    /**
     * Provides valid and invalid Lines data
     * @return array
     */
    public function linesProvider()
    {
        return [
            [[new Line(), new Line()], true],
            [[new Line(), new stdClass()], false],
            [[new stdClass(), new stdClass()], false],
            [[new stdClass(), 'foobar'], false],
            [[new Line(), 'foobar'], false],
        ];
    }
}
