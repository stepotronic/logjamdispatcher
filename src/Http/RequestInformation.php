<?php

namespace LogjamDispatcher\Http;

class RequestInformation implements RequestInformationInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $queryParameters = [];

    /**
     * @var array
     */
    protected $bodyParameters = [];

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param  string $method
     * 
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  string $url
     * 
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * @param  array $headers
     * 
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * @param  array $queryParameters
     * 
     * @return $this
     */
    public function setQueryParameters(array $queryParameters)
    {
        $this->queryParameters = $queryParameters;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addQueryParameter($name, $value)
    {
        $this->queryParameters[$name] = $value;
    }
    
    /**
     * @return array
     */
    public function getBodyParameters()
    {
        return $this->bodyParameters;
    }

    /**
     * @param  array $bodyParameters
     * 
     * @return $this
     */
    public function setBodyParameters(array $bodyParameters)
    {
        $this->bodyParameters = $bodyParameters;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     */
    public function addBodyParameter($name, $value)
    {
        $this->bodyParameters[$name] = $value;
    }
}
