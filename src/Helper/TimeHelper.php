<?php

namespace LogjamDispatcher\Helper;

class TimeHelper
{
    /**
     * @param \DateTime $dateTime
     *
     * @return int
     */
    public static function convertDateTimeToMicrotime(\DateTime $dateTime)
    {
        $microtime = (float)$dateTime->getTimestamp() * 1000000;
        $microtime += (int)substr($dateTime->format('u'), -6);

        return $microtime / 1000;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return int
     */
    public static function convertDateTimeToMillitime(\DateTime $dateTime)
    {
        $millitime = (float)$dateTime->getTimestamp() * 1000;
        $millitime += (int)substr($dateTime->format('u'), -6, 3);

        return $millitime;
    }
}
