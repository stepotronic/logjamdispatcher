<?php

namespace LogjamDispatcher\Logjam;

use LogjamDispatcher\Http\RequestInformationInterface;

interface MessageInterface extends \JsonSerializable
{
    /**
     * Returns the Action Name 
     * Pattern: Logjam::LogjamController#index
     * @return string
     */
    public function getAction();
    
    /**
     * @return int
     */
    public function getRequestStartedTimestamp();

    /**
     * @return int
     */
    public function getRequestStartedTimestampInMilliseconds();

    /**
     * @return float
     */
    public function getTotalTime();

    /**
     * @return int
     */
    public function getResponseCode();

    /**
     * @return int
     */
    public function getSeverity();

    /**
     * @return string
     */
    public function getCallerId();

    /**
     * @return string
     */
    public function getCallerAction();

    /**
     * @return string
     */
    public function getUserId();

    /**
     * @return string
     */
    public function getHost();

    /**
     * @return string
     */
    public function getIp();

    /**
     * @return \Exception[]
     */
    public function getExceptions();

    /**
     * @return array
     */
    public function getAdditionalData();
    
    /**
     * @return int|null
     */
    public function getDbCalls();

    /**
     * @return float|null
     */
    public function getDbTime();

    /**
     * @return boolean
     */
    public function hasLines();
    
    /**
     * @return array
     */
    public function getLines();

    /**
     * @return RequestIdInterface
     */
    public function getRequestId();
    
    /**
     * @return RequestInformationInterface
     */
    public function getHttpRequestInformation();
}
