<?php

namespace LogjamDispatcher\Http;

class FilteredRequestInformationDecorator implements RequestInformationInterface
{
    /**
     * @var RequestInformationInterface
     */
    protected $requestInformation;

    /**
     * @var array
     */
    protected $filterFields;

    /**
     * @var string
     */
    protected $filterMask;

    /**
     * RequestInformationProxy constructor.
     * @param RequestInformationInterface $requestInformation
     * @param array $filterFields
     * @param string $filterMask
     */
    public function __construct(RequestInformationInterface $requestInformation, array $filterFields, $filterMask = '*****')
    {
        $this->requestInformation = $requestInformation;
        $this->filterFields = $filterFields;
        $this->filterMask = $filterMask;
    }


    /**
     * HTTP Method
     * @return string
     */
    public function getMethod()
    {
        return $this->requestInformation->getMethod();
    }

    /**
     * Request URL
     * @return string
     */
    public function getUrl()
    {
        return $this->requestInformation->getUrl();
    }

    /**
     * Header Parameters
     * @return array
     */
    public function getHeaders()
    {
        return $this->requestInformation->getHeaders();
    }

    /**
     * Query Parameters (GET Parameters)
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->filter($this->requestInformation->getQueryParameters());
    }

    /**
     * BodyParameters
     * @return array
     */
    public function getBodyParameters()
    {
        return $this->filter($this->requestInformation->getBodyParameters());
    }

    /**
     * @param  $array
     * @return $array
     */
    protected function filter($array)
    {
        foreach($array as $key => &$value) {
            if(in_array($key, $this->filterFields)) {
                $value = $this->filterMask;
            }
        }
        
        return $array;
    }
}
