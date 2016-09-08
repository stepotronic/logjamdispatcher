<?php

abstract class AbstractRequestIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \LogjamDispatcher\Logjam\RequestIdInterface
     */
    protected $instance;
    
    protected abstract function getRequestIdInstance();
    
    public function setUp()
    {
        $this->instance = $this->getRequestIdInstance();
    }

}