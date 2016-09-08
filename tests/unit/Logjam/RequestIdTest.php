<?php

use LogjamDispatcher\Logjam\RequestId;

/**
 * Class RequestIdTest
 * @property RequestId $instance
 */
class RequestIdTest extends AbstractRequestIdTest
{
    protected function getRequestIdInstance()
    {
        return new RequestId();
    }
    
    public function testRequestGetIdProxy()
    {
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getId());
        $this->assertSame(32, strlen($this->instance->getId()));
    }
    
    public function testRequestId()
    {
        $testId = "iamatestid";
        $this->instance->setId($testId);
        $this->assertSame($testId, $this->instance->getId());
    }
}