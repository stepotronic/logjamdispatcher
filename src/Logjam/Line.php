<?php

namespace LogjamDispatcher\Logjam;

use Cvmaker\Xing\User\Date;
use LogjamDispatcher\Dispatcher\Expression;
use LogjamDispatcher\Helper\TimeHelper;

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
     * @var \DateTime
     */
    protected $microTime;

    /**
     * Line constructor.
     * @param int $severity
     * @param string $message
     * @param \DateTime $microTime
     */
    public function __construct($severity = Expression\Severity::UNKOWN, $message = '', \DateTime $microTime = null)
    {
        $this->severity = $severity;
        $this->message = $message;
        $this->microTime = $microTime ? $microTime : TimeHelper::getMicrotime();
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
     * @return \DateTime
     */
    public function getMicroTime()
    {
        return $this->microTime;
    }

}
