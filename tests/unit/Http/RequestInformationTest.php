<?php

use LogjamDispatcher\Http\RequestInformation;

/**
 * Class RequestInformationTest
 * @property RequestInformation $instance
 */
class RequestInformationTest extends AbstractRequestInformationTest
{
    /**
     * @return RequestInformation
     */
    protected function getRequestInformationInstance()
    {
        return new RequestInformation();
    }

    /**
     * Test method getter/setter
     */
    public function testMethod()
    {
        $testMethod = "POST";

        $this->assertSame(null, $this->instance->getMethod());
        $this->instance->setMethod($testMethod);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getMethod());
        $this->assertSame($testMethod, $this->instance->getMethod());
    }

    /**
     * Test getter/setter for Url
     */
    public function testUrl()
    {
        $testUrl = "https://foo.bar/foobar";

        $this->assertSame(null, $this->instance->getUrl());
        $this->instance->setUrl($testUrl);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->instance->getUrl());
        $this->assertSame($testUrl, $this->instance->getUrl());
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testHeaders($headers)
    {
        $additionalTestHeader = ["test" => "additional"];
        
        $this->assertCount(0, $this->instance->getHeaders());
        
        $this->instance->setHeaders($headers);
        $this->assertEquals($headers, $this->instance->getHeaders(), "", 0.0, 10, true, false);
        
        $this->instance->addHeader("test", $additionalTestHeader["test"]);
        $headers = array_merge($headers, $additionalTestHeader);
        $this->assertEquals($headers, $this->instance->getHeaders(), "", 0.0, 10, true, false);
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testQueryParameters($queryParameter)
    {
        $additionalTestQueryParameter = ["test" => "additional"];

        $this->assertCount(0, $this->instance->getQueryParameters());

        $this->instance->setQueryParameters($queryParameter);
        $this->assertEquals($queryParameter, $this->instance->getQueryParameters(), "", 0.0, 10, true, false);

        $this->instance->addQueryParameter("test", $additionalTestQueryParameter["test"]);
        $queryParameter = array_merge($queryParameter, $additionalTestQueryParameter);
        $this->assertEquals($queryParameter, $this->instance->getQueryParameters(), "", 0.0, 10, true, false);
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testBodyParameters($bodyParameter)
    {
        $additionalTestBodyParameter = ["test" => "additional"];

        $this->assertCount(0, $this->instance->getBodyParameters());

        $this->instance->setBodyParameters($bodyParameter);
        $this->assertEquals($bodyParameter, $this->instance->getBodyParameters(), "", 0.0, 10, true, false);

        $this->instance->addBodyParameter("test", $additionalTestBodyParameter["test"]);
        $bodyParameter = array_merge($bodyParameter, $additionalTestBodyParameter);
        $this->assertEquals($bodyParameter, $this->instance->getBodyParameters(), "", 0.0, 10, true, false);
    }

    /**
     * Provides 2 example parameter arrays
     * @return array
     */
    public function parameterProvider()
    {
        return [
            [[
                'Accept'    => 'Nothing',
                'Foo'       => 'Bar',
                'Feels'     => 'BadMan',
            ]],
            [[
                'Decline'   => 'Nothing',
                'Bar'       => 'Foo',
            ]],
        ];
    }
}
