<?php

abstract class AbstractMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \LogjamDispatcher\Logjam\MessageInterface
     */
    protected $instance;
    
    protected abstract function getMessageInstance();
    
    public function setUp()
    {
        $this->instance = $this->getMessageInstance();
    }

}