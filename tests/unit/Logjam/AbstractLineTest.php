<?php

abstract class AbstractLineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \LogjamDispatcher\Logjam\LineInterface
     */
    protected $instance;

    /**
     * @var \DateTime
     */
    protected $microtime;
    
    protected abstract function getLineInstance();
    
    public function setUp()
    {
        $this->microtime = new DateTime("now", new DateTimeZone("Europe/Berlin"));
        $this->instance = $this->getLineInstance();
    }

}