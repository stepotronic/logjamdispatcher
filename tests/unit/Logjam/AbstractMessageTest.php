<?php

use LogjamDispatcher\Logjam\MessageInterface;

abstract class AbstractMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageInterface
     */
    protected $instance;

    /**
     * @return MessageInterface
     */
    protected abstract function getMessageInstance();

    /**
     * Create an Instance of MessageInterface
     */
    public function setUp()
    {
        $this->instance = $this->getMessageInstance();
    }

}
