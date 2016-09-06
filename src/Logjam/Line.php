<?php

namespace LogjamDispatcher\Logjam;

use LogjamDispatcher\Dispatcher\Expression;

class Line implements LineInterface
{
    /**
     * @var int
     */
    protected $severity;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $microTimestamp;

    /**
     * Line constructor.
     * @param int $severity
     * @param string $message
     * @param string $microTimestamp
     */
    public function __construct($severity = Expression\Severity::UNKOWN, $message = '', $microTimestamp = '')
    {
        $this->severity = $severity;
        $this->message = $message;
        $this->microTimestamp = $microTimestamp;
    }

    /**
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getMicroTimestamp()
    {
        return $this->microTimestamp;
    }
}
