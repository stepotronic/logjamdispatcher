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
    
    /**
     * @deprecated with getMicrotimeDateTime
     * @return \DateTime
     */
    public static function getMicrotime()
    {
        return self::getMicrotimeDateTime();
    }
    
    /**
     * Returns a DateTime Object with a microtime precision.
     *
     * @param float $microtime
     *
     * @return bool|\DateTime
     */
    public static function getMicrotimeDateTime($microtime = null)
    {
        if (!is_float($microtime)) {
            $microtime = microtime(true);
        }
        // to ensure we have digits after the decimal point we need to use number_format otherwise false would be returned
   
        return \DateTime::createFromFormat('U.u', number_format($microtime, 4, '.', ''));
    }    

}
