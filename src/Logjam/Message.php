<?php

namespace LogjamDispatcher\Logjam;

use LogjamDispatcher\Helper\TimeHelper;
use LogjamDispatcher\Dispatcher\Expression;
use LogjamDispatcher\Http\RequestInformationInterface;

/**
 * Message for required data for logjam.
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $action;
    
    /**
     * @var \DateTime
     */
    protected $requestStartedAt;
    
    /**
     * @var \DateTime
     */
    protected $requestEndedAt;
    
    /**
     * @var int
     */
    protected $responseCode;
    
    /**
     * @var int
     */
    protected $severity = Expression\Severity::UNKOWN;
    
    /**
     * @var string
     */
    protected $callerId;
    
    /**
     * @var string
     */
    protected $callerAction;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var string
     */
    protected $host;
    
    /**
     * @var string
     */
    protected $ip;
    
    /**
     * @var RequestIdInterface
     */
    protected $requestId;
    
    /**
     * @var array
     */
    protected $url = [];
    
    /**
     * @var array
     */
    protected $exceptions = [];
    
    /**
     * @var array
     */
    protected $additionalData = [];
    
    /**
     * @var float
     */
    protected $dbTime;

    /**
     * @var int
     */
    protected $dbCalls;

    /**
     * @var LineInterface[]
     */
    protected $lines = [];

    /**
     * @var RequestInformationInterface
     */
    protected $requestInformation;
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @param string $action
     * 
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }    
    
    /**
     * @return \DateTime
     */
    public function getRequestStartedAt()
    {
        return $this->requestStartedAt;
    }
    
    /**
     * @param \DateTime $requestStartedAt
     * 
     * @return $this
     */
    public function setRequestStartedAt(\DateTime $requestStartedAt)
    {
        $this->requestStartedAt = $requestStartedAt;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRequestEndedAt()
    {
        return $this->requestEndedAt;
    }
    
    /**
     * @param \DateTime $requestEndedAt
     * 
     * @return $this
     */
    public function setRequestEndedAt(\DateTime $requestEndedAt)
    {
        $this->requestEndedAt = $requestEndedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalTime()
    {
        return TimeHelper::convertDateTimeToMicrotime($this->getRequestEndedAt()) - TimeHelper::convertDateTimeToMicrotime($this->getRequestStartedAt());
    }
    
    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    
    /**
     * @param string $responseCode
     * 
     * @return $this
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }
    
    /**
     * @param int $severity
     * 
     * @return $this
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCallerId()
    {
        return $this->callerId;
    }
    
    /**
     * @param string $callerId
     * 
     * @return $this
     */
    public function setCallerId($callerId)
    {
        $this->callerId = $callerId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCallerAction()
    {
        return $this->callerAction;
    }
    
    /**
     * @param string $callerAction
     * 
     * @return $this
     */
    public function setCallerAction($callerAction)
    {
        $this->callerAction = $callerAction;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * @param int $userId
     * 
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * @param string $host
     * 
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
    
    /**
     * @param string $ip
     * 
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    
    /**
     * @return RequestIdInterface
     */
    public function getRequestId()
    {
        return $this->requestId;
    }
    
    /**
     * @param RequestIdInterface $requestId
     * 
     * @return $this
     */
    public function setRequestId(RequestIdInterface $requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return array
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @param array $url
     * 
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return \Exception[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
    
    /**
     * @param  \Exception[] $exceptions
     * 
     * @return $this
     */
    public function setExceptions($exceptions)
    {
        $this->exceptions = $exceptions;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }
    
    /**
     * @param array $additionalData
     * 
     * @return $this
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    /**
     * @param float $dbTime
     * 
     * @return $this
     */
    public function setDbTime($dbTime)
    {
        $this->dbTime = $dbTime;
        return $this;
    }

    /**
     * @return float
     */
    public function getDbTime()
    {
        return $this->dbTime;
    }

    /**
     * @param  int $dbCalls
     * 
     * @return $this
     */
    public function setDbCalls($dbCalls)
    {
        $this->dbCalls = $dbCalls;
        return $this;
    }

    /**
     * @return int
     */
    public function getDbCalls()
    {
        return $this->dbCalls;
    }

    /**
     * Adds a log line
     * @param LineInterface $line
     * 
     * @return $this
     */
    public function addLine(LineInterface $line)
    {
        $this->lines[] = $line;
        
        return $this;
    }

    /**
     * Returns the log lines
     * 
     * @return LineInterface[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return bool
     */
    public function hasLines()
    {
        return count($this->lines) > 0;
    }

    /**
     * @param $requestInformation
     * 
     * @return $this
     */
    public function setRequestInformation($requestInformation)
    {
        $this->requestInformation = $requestInformation;
        
        return $this;
    }
    
    
    /**
     * @return RequestInformationInterface
     */
    public function getHttpRequestInformation()
    {
        return $this->requestInformation;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $logArray =  [
            // required
            'action'        => $this->getAction(),
            'started_at'    => $this->getRequestStartedAt()->format('c'), // ISO 8601
            'started_ms'    => TimeHelper::convertDateTimeToMillitime($this->getRequestStartedAt()),
            'total_time'    => $this->getTotalTime(),
            'code'          => $this->getResponseCode(),
            'severity'      => $this->getSeverity(),
            'caller_id'     => $this->getCallerId(),
            'caller_action' => $this->getCallerAction(),
            'user_id'       => $this->getUserId(),
            'host'          => $this->getHost(),
            'ip'            => $this->getIp(),
            'request_info'   => [
                'query_parameters' => $this->getHttpRequestInformation()->getQueryParameters(),
                'headers'          => $this->getHttpRequestInformation()->getHeaders(),
                'url'               => $this->getHttpRequestInformation()->getUrl(),
                'method'           => $this->getHttpRequestInformation()->getMethod(),
                'body_parameters'  => $this->getHttpRequestInformation()->getBodyParameters(),
            ],
            'exceptions'     => $this->getExceptions(),
            'message'        => $this->getAdditionalData(),
            'request_id'     => $this->getRequestId()->getId(),
        ];


        // Optional parameters
        if ($this->getDbCalls() !== null) {
            $logArray['db_calls'] = $this->getDbCalls();
        }

        if ($this->getDbTime() !== null) {
            $logArray['db_time'] = $this->getDbTime();
        }

        if ($this->hasLines()) {
            $logArray['lines'] = [];
            
            foreach ($this->getLines() as $line) {
                $logArray['lines'][] = [$line->getSeverity(), TimeHelper::convertDateTimeToMicrotime($line->getMicroTime()), $line->getMessage()];
            }
        }
        
        return $logArray;
    }
}
