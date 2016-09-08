<?php

use LogjamDispatcher\Logjam\Line;
use LogjamDispatcher\Dispatcher\Expression;

/**
 * Class LineTest
 * @property Line $instance
 */
class LineTest extends AbstractLineTest
{
    /**
     * @return Line
     */
    protected function getLineInstance()
    {
        return new Line(Expression\Severity::DEBUG, 'foobar', $this->microtime);
    }

    /**
     * Test severity getter
     */
    public function testGetSeverity()
    {
        $this->assertSame(Expression\Severity::DEBUG, $this->instance->getSeverity());
    }

    /**
     * test message getter
     */
    public function testGetMessage()
    {
        $this->assertSame('foobar', $this->instance->getMessage());
    }

    /**
     * test microtimestammp getter
     */
    public function testGetMicroTime()
    {
        $this->assertSame($this->microtime, $this->instance->getMicroTime());
    }
}
