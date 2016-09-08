<?php

abstract class AbstractRequestInformationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \LogjamDispatcher\Http\RequestInformationInterface
     */
    protected $instance;
    
    protected abstract function getRequestInformationInstance();
    
    public function setUp()
    {
        $this->instance = $this->getRequestInformationInstance();
    }

}