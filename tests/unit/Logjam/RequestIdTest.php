<?php

use LogjamDispatcher\Logjam\RequestId;

/**
 * Class RequestIdTest
 * @property RequestId $instance
 */
class RequestIdTest extends AbstractRequestIdTest
{
    /**
     * @return RequestId
     */
    protected function getRequestIdInstance()
    {
        return new RequestId();
    }

    /**
     * Test the null object proxy
     */
    public function testRequestGetIdProxy()
    {
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getId());
        $this->assertSame(32, strlen($this->instance->getId()));
    }

    /**
     * Tests the id getter
     */
    public function testRequestId()
    {
        $testId = "iamatestid";
        $this->instance->setId($testId);
        $this->assertSame($testId, $this->instance->getId());
    }
}