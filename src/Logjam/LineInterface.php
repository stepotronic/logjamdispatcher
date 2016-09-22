<?php

namespace LogjamDispatcher\Logjam;

interface LineInterface
{
    /**
     * @return int
     */
    public function getSeverity();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return \DateTime
     */
    public function getMicroTime();
}
