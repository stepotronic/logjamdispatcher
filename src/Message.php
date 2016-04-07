<?php

namespace LogjamDispatcher;

/**
 * Message for required data for logjam.
 */
class Message
{
    /**
     * @var int
     */
    const SEVERITY_DEBUG = 0;

    /**
     * @var int
     */
    const SEVERITY_INFO = 1;

    /**
     * @var int
     */
    const SEVERITY_WARN = 2;

    /**
     * @var int
     */
    const SEVERITY_ERROR = 3;

    /**
     * @var int
     */
    const SEVERITY_FATAL = 4;
    
    /**
     * @var int
     */
    const SEVERITY_UNKOWN = 5;

    /**
     * @var string
     */
    protected $action = 0;
    
    /**
     * @var int
     */
    protected $requestStartedTimestamp = 0;
    
    /**
     * @var int
     */
    protected $requestStartedTimestampInMilliseconds = 0;
    
    /**
     * @var float
     */
    protected $totalTime = 0.0;
    
    /**
     * @var string
     */
    protected $responseCode = '';
    
    /**
     * @var int
     */
    protected $severity = self::SEVERITY_UNKOWN;
    
    /**
     * @var string
     */
    protected $callerId = '';
    
    /**
     * @var string
     */
    protected $callerAction = '';
    
    /**
     * @var int
     */
    protected $userId = 0;
    
    /**
     * @var string
     */
    protected $host = '';
    
    /**
     * @var string
     */
    protected $ip = '';
    
    /**
     * @var string
     */
    protected $requestId = '';
    
    /**
     * @var array
     */
    protected $queryParameters = array();
    
    /**
     * @var array
     */
    protected $headers = array();
    
    /**
     * @var array
     */
    protected $url = array();
    
    /**
     * @var string
     */
    protected $method = '';
    
    /**
     * @var
     */
    protected $bodyParameters;
    
    /**
     * @var array
     */
    protected $exceptions = array();
    
    /**
     * @var array
     */
    protected $additionalData = array();
    
    /**
     * @var float
     */
    protected $dbTime = null;

    /**
     * @var int
     */
    protected $dbCalls = null;

    /**
     * @var array
     */
    protected $lines = [];
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }    
    
    /**
     * @return int
     */
    public function getRequestStartedTimestamp()
    {
        return $this->requestStartedTimestamp;
    }
    
    /**
     * @param int $requestStartedTimestamp
     * @return $this
     */
    public function setRequestStartedTimestamp($requestStartedTimestamp)
    {
        $this->requestStartedTimestamp = $requestStartedTimestamp;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRequestStartedTimestampInMilliseconds()
    {
        return $this->requestStartedTimestampInMilliseconds;
    }
    
    /**
     * @param int $requestStartedTimestampInMilliseconds
     * @return $this
     */
    public function setRequestStartedTimestampInMilliseconds($requestStartedTimestampInMilliseconds)
    {
        $this->requestStartedTimestampInMilliseconds = $requestStartedTimestampInMilliseconds;
        return $this;
    }
    
    /**
     * @return float
     */
    public function getTotalTime()
    {
        return $this->totalTime;
    }
    
    /**
     * @param float $totalTime
     * @return $this
     */
    public function setTotalTime($totalTime)
    {
        $this->totalTime = $totalTime;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    
    /**
     * @param string $responseCode
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
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }
    
    /**
     * @param string $requestId
     * @return $this
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }
    
    /**
     * @param array $queryParameters
     * @return $this
     */
    public function setQueryParameters($queryParameters)
    {
        $this->queryParameters = $queryParameters;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    
    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
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
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBodyParameters()
    {
        return $this->bodyParameters;
    }
    
    /**
     * @param mixed $bodyParameters
     * @return $this
     */
    public function setBodyParameters($bodyParameters)
    {
        $this->bodyParameters = $bodyParameters;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
    
    /**
     * @param array $exceptions
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
     * @return $this
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    /**
     * @param float $dbTime
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
     * @param int $dbTime
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
     * @param int $severity
     * @param string $timestamp
     * @param string $info
     * @return $this
     */
    public function addLine($severity, $timestamp, $info)
    {
        $this->lines[] = [$severity, $timestamp, $info];

        if ($this->getSeverity() == self::SEVERITY_UNKOWN) {
            $this->setSeverity($severity);
        } else {
            $this->setSeverity(max($severity, $this->getSeverity()));
        }

        return $this;
    }

    /**
     * Returns the log lines
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }
}
