<?php

use LogjamDispatcher\Logjam\RequestIdInterface;

abstract class AbstractRequestIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestIdInterface
     */
    protected $instance;

    /**
     * @return RequestIdInterface
     */
    protected abstract function getRequestIdInstance();

    /**
     * Create an instance of RequestIdInterface
     */
    public function setUp()
    {
        $this->instance = $this->getRequestIdInstance();
    }

}
