<?php

namespace LogjamDispatcher\Http;

interface RequestInformationInterface
{
    /**
     * HTTP Method
     * @return string
     */
    public function getMethod();

    /**
     * Request URL
     * @return string
     */
    public function getUrl();
    
    /**
     * Header Parameters
     * @return array
     */
    public function getHeaders();

    /**
     * Query Parameters (GET Parameters)
     * @return array
     */
    public function getQueryParameters();

    /**
     * BodyParameters
     * @return array
     */
    public function getBodyParameters();
}
