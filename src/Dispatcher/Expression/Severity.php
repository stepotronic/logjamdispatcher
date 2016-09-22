<?php

namespace LogjamDispatcher\Dispatcher\Expression;

class Severity
{
    /**
     * @var int
     */
    const DEBUG = 0;

    /**
     * @var int
     */
    const INFO = 1;

    /**
     * @var int
     */
    const WARN = 2;

    /**
     * @var int
     */
    const ERROR = 3;

    /**
     * @var int
     */
    const FATAL = 4;

    /**
     * @var int
     */
    const UNKOWN = 5;

    /**
     * @var array
     */
    static public $all = [
        self::DEBUG,
        self::INFO,
        self::WARN,
        self::ERROR,
        self::FATAL,
        self::UNKOWN,
    ];
}
