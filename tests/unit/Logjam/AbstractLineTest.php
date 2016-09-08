<?php

use LogjamDispatcher\Logjam\LineInterface;

abstract class AbstractLineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LineInterface
     */
    protected $instance;

    /**
     * @var \DateTime
     */
    protected $microtime;

    /**
     * @return LineInterface
     */
    protected abstract function getLineInstance();

    /**
     * Create an instance of LineInterface and prepare a dummy DateTime
     */
    public function setUp()
    {
        $this->microtime = new DateTime("now", new DateTimeZone("Europe/Berlin"));
        $this->instance = $this->getLineInstance();
    }

}
