<?php

use LogjamDispatcher\Http\RequestInformationInterface;

abstract class AbstractRequestInformationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestInformationInterface
     */
    protected $instance;

    /**
     * @return RequestInformationInterface
     */
    protected abstract function getRequestInformationInstance();

    /**
     * Prepares and instance of RequestInformationInterface
     */
    public function setUp()
    {
        $this->instance = $this->getRequestInformationInstance();
    }

}
