<?php

namespace LogjamDispatcher\Validator;

use LogjamDispatcher\Dispatcher\Expression;
use LogjamDispatcher\Exception\ValidationException;
use LogjamDispatcher\Http\RequestInformationInterface;
use LogjamDispatcher\Logjam\LineInterface;
use LogjamDispatcher\Logjam\MessageInterface;
use LogjamDispatcher\Logjam\RequestIdInterface;

/**
 * Class MessageValidator
 * @package LogjamDispatcher\Validator
 * @see https://github.com/skaes/logjam-tools/blob/master/specs/json_payload.md
 */
class MessageValidator
{
    const TYPE_ERROR = 'Expected %s, %s given.';
    const SEVERITY_ERROR = 'Expected valid severity (%s).';
    const EXCEPTIONS_ERROR = 'Not an Exception';
    const ADDITIONAL_DATA_ERROR = 'Additional data should not be deeper than 1 level.';
    const HTTP_CODE_ERROR = 'Expected HTTP status code, %s given';
    
    const REQUEST_ID_NULL_EXCEPTION = 'Request id is required and cannot be NULL.';
    const REQUEST_INFORMATION_NULL_EXCEPTION = 'Request informations are required and cannot be NULL';
    
    
    /**
     * @param MessageInterface $message
     */
    public static function validate(MessageInterface $message)
    {
        self::validateAction($message->getAction());
        self::validateAdditionalData($message->getAdditionalData());
        self::validateCallerAction($message->getCallerAction());
        self::validateCallerId($message->getCallerId());
        self::validateDbCalls($message->getDbCalls());
        self::validateDbTime($message->getDbTime());
        self::validateExceptions($message->getExceptions());
        self::validateHost($message->getHost());
        self::validateHttpRequestInformation($message->getHttpRequestInformation());
    }

    /**
     * @param  string $action
     * 
     * @throws ValidationException
     */
    public static function validateAction($action)
    {
        if (!is_string($action)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($action)));
        }
        
        if (!preg_match('/^\w+\:\:\w+\#\w+/', $action)) {
            throw new ValidationException('Format of given action is not well formatted. Choose a format in following pattern: "Logjam::LogjamController#index" (/^\\w+\\:\\:\\w+\\#\\w+/).');
        }
    }

    /**
     * @param  int $requestStartedTimestamp
     * 
     * @throws ValidationException
     */
    public static function validateRequestStartedTimestamp($requestStartedTimestamp)
    {
        if (!is_int($requestStartedTimestamp)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "integer", gettype($requestStartedTimestamp)));
        }
    }

    /**
     * @param  float $totalTime
     * 
     * @throws ValidationException
     */
    public static function validateTotalTime($totalTime)
    {
        if (!is_float($totalTime)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "float", gettype($totalTime)));
        }
    }

    /**
     * @param  int $responseCode
     * 
     * @throws ValidationException
     */
    public static function validateResponseCode($responseCode)
    {
        if (!is_int($responseCode)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "integer", gettype($responseCode)));
        }
        
        if ($responseCode < 100 || $responseCode > 511) {
            throw new ValidationException(sprintf(self::HTTP_CODE_ERROR, $responseCode));
        }
    }

    /**
     * @param  int $severity
     * 
     * @throws ValidationException
     */
    public static function validateSeverity($severity)
    {
        if (!is_int($severity)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "integer", gettype($severity)));
        }
        
        if (!in_array($severity, Expression\Severity::$all)) {
            throw new ValidationException(sprintf(self::SEVERITY_ERROR, implode(', ', Expression\Severity::$all)));
        }
    }

    /**
     * @param  string $callerId
     * 
     * @throws ValidationException
     */
    public static function validateCallerId($callerId)
    {
        if (!is_string($callerId)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($callerId)));
        }
    }

    /**
     * @param  string $callerAction
     * 
     * @throws ValidationException
     */
    public static function validateCallerAction($callerAction)
    {
        if (!is_string($callerAction)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($callerAction)));
        }
    }

    /**
     * @param  string $userId
     * 
     * @throws ValidationException
     */
    public static function validateUserId($userId)
    {
        if (!is_string($userId)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($userId)));
        }
    }

    /**
     * @param  string $host
     * 
     * @throws ValidationException
     */
    public static function validateHost($host)
    {
        if (!is_string($host)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($host)));
        }
    }

    /**
     * @param  string $ip
     * 
     * @throws ValidationException
     */
    public static function validateIp($ip)
    {
        if (!is_string($ip)) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "string", gettype($ip)));
        }
    }

    /**
     * @param  \Exception[] $exceptions
     * 
     * @throws ValidationException
     */
    public static function validateExceptions(array $exceptions)
    {
        foreach ($exceptions as $exception) {
            if (!$exception instanceof \Exception) {
                throw new ValidationException(self::EXCEPTIONS_ERROR);
            }
        }
    }

    /**
     * @param $additionalData
     * 
     * @throws ValidationException
     */
    public static function validateAdditionalData($additionalData)
    {
        foreach($additionalData as $row) {
            if (is_array($row)) {
                throw new ValidationException(self::ADDITIONAL_DATA_ERROR);
            }
        }
    }

    /**
     * Validates db calls. Can also be null as it is not required
     * @param  int|null $dbCalls
     * 
     * @throws ValidationException
     */
    public static function validateDbCalls($dbCalls)
    {
        if (!is_int($dbCalls) && $dbCalls !== null) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "integer", gettype($dbCalls)));
        }
    }

    /**
     * Validates db time. Can also be null as it is not required
     * @param float|null $dbTime
     * 
     * @throws ValidationException
     */
    public static function validateDbTime($dbTime)
    {
        if (!is_float($dbTime) && $dbTime !== null) {
            throw new ValidationException(sprintf(self::TYPE_ERROR, "float", gettype($dbTime)));
        }
    }

    /**
     * @param array $lines
     * 
     * @throws ValidationException
     */
    public static function validateLines(array $lines)
    {
        foreach ($lines as $line) {
            if (!$line instanceof LineInterface) {
                throw new ValidationException(sprintf(self::TYPE_ERROR, LineInterface::class, self::formatValueToString($line)));
            }
        }
    }

    /**
     * @param  RequestIdInterface $requestId
     * 
     * @throws ValidationException
     */
    public static function validateRequestId($requestId)
    {
        if ($requestId === null) {
            throw new ValidationException(self::REQUEST_ID_NULL_EXCEPTION);
        }
    }

    /**
     * @param  RequestInformationInterface $httpRequestInformation
     * 
     * @throws ValidationException
     */
    public static function validateHttpRequestInformation($httpRequestInformation)
    {
        if ($httpRequestInformation === null) {
            throw new ValidationException(self::REQUEST_INFORMATION_NULL_EXCEPTION);
        }
    }

    /**
     * @param mixed $value
     */
    static public function formatValueToString($value) {
        if('object' === ($type = gettype($value))) {
            return get_class($value);
        }
        
        return $type;
    }
}
