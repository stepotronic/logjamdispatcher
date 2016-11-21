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
     * @return \DateTime
     */
    public function getRequestStartedAt();

    /**
     * @param \DateTime|null $timestamp
     *
     * @return MessageInterface
     */
    public function setRequestStartedAt(\DateTime $timestamp = null);

    /**
     * @return \DateTime
     */
    public function getRequestEndedAt();

    /**
     * @param \DateTime|null $timestamp
     *
     * @return MessageInterface
     */
    public function setRequestEndedAt(\DateTime $timestamp = null);

    /**
     * @return int
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
     * Sets the current severity to the highest severity amoung the lines.
     */
    public function setSeverityToMax();

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
     * @param \Exception $exception
     */
    public function addException(\Exception $exception);

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
