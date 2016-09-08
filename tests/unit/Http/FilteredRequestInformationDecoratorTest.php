<?php

use LogjamDispatcher\Http\RequestInformation;
use LogjamDispatcher\Http\FilteredRequestInformationDecorator;

/**
 * Class RequestInformationTest
 * @property RequestInformation $instance
 */

class FilteredRequestInformationDecoratorTest extends AbstractRequestInformationTest
{
    const TEST_FILTER_MASK = '*****';
    const TEST_FILTER_FIELD = 'password';
    
    /**
     * @var FilteredRequestInformationDecorator
     */
    protected $decorator;

    /**
     * prepare an Message instance and a decorator
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->decorator = new FilteredRequestInformationDecorator($this->instance, array(self::TEST_FILTER_FIELD), self::TEST_FILTER_MASK);
    }

    /**
     * @return RequestInformation
     */
    protected function getRequestInformationInstance()
    {
        return new RequestInformation();
    }

    /**
     * test getter/setter for method
     */
    public function testMethod()
    {
        $testMethod = "POST";

        $this->assertSame(null, $this->decorator->getMethod());
        $this->instance->setMethod($testMethod);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->decorator->getMethod());
        $this->assertSame($testMethod, $this->decorator->getMethod());
    }

    /**
     * test url getter/setter
     */
    public function testUrl()
    {
        $testUrl = "https://foo.bar/foobar";

        $this->assertSame(null, $this->decorator->getUrl());
        $this->instance->setUrl($testUrl);
        $this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $this->decorator->getUrl());
        $this->assertSame($testUrl, $this->decorator->getUrl());
    }

    /**
     * test header set/get/add methods
     * 
     * @dataProvider parameterProvider
     */
    public function testHeaders($headers)
    {
        $additionalTestHeader = array("test" => "additional");

        $this->assertCount(0, $this->decorator->getHeaders());

        $this->instance->setHeaders($headers);
        $this->assertEquals($headers, $this->decorator->getHeaders(), "", 0.0, 10, true, false);

        $this->instance->addHeader("test", $additionalTestHeader["test"]);
        $headers = array_merge($headers, $additionalTestHeader);
        $this->assertEquals($headers, $this->decorator->getHeaders(), "", 0.0, 10, true, false);
    }

    /**
     * test queryParameters add/get/set methods
     * 
     * @dataProvider parameterProvider
     */
    public function testQueryParameters($queryParameter)
    {
        $additionalTestQueryParameter = array("test" => "additional");

        $this->assertCount(0, $this->decorator->getQueryParameters());

        $this->instance->setQueryParameters($queryParameter);
        $this->assertEquals($queryParameter, $this->decorator->getQueryParameters(), "", 0.0, 10, true, false);

        $this->instance->addQueryParameter("test", $additionalTestQueryParameter["test"]);
        $queryParameter = array_merge($queryParameter, $additionalTestQueryParameter);
        $this->assertEquals($queryParameter, $this->decorator->getQueryParameters(), "", 0.0, 10, true, false);
    }

    /**
     * test bodyParameters add/get/set methods
     * 
     * @dataProvider parameterProvider
     */
    public function testBodyParameters($bodyParameter)
    {
        $additionalTestBodyParameter = array("test" => "additional");

        $this->assertCount(0, $this->decorator->getBodyParameters());

        $this->instance->setBodyParameters($bodyParameter);
        $this->assertEquals($bodyParameter, $this->decorator->getBodyParameters(), "", 0.0, 10, true, false);

        $this->instance->addBodyParameter("test", $additionalTestBodyParameter["test"]);
        $bodyParameter = array_merge($bodyParameter, $additionalTestBodyParameter);
        $this->assertEquals($bodyParameter, $this->decorator->getBodyParameters(), "", 0.0, 10, true, false);
    }


    /**
     * test filter for body parameters
     * 
     * @dataProvider credentialParameterProvider
     */
    public function testBodyParametersFilter($bodyParameter)
    {
        $this->instance->setBodyParameters($bodyParameter);
        
        if (array_key_exists(self::TEST_FILTER_FIELD, $bodyParameter)) {
            $this->assertNotEquals($bodyParameter, $this->decorator->getBodyParameters(), "", 0.0, 10, true, false);
            $this->assertSame(self::TEST_FILTER_MASK, $this->decorator->getBodyParameters()[self::TEST_FILTER_FIELD]);
        }
    }

    /**
     * test filter for query parameters
     * 
     * @dataProvider credentialParameterProvider
     */
    public function testQueryParametersFilter($queryParameter)
    {
        $this->instance->setQueryParameters($queryParameter);

        if (array_key_exists(self::TEST_FILTER_FIELD, $queryParameter)) {
            $this->assertNotEquals($queryParameter, $this->decorator->getQueryParameters(), "", 0.0, 10, true, false);
            $this->assertSame(self::TEST_FILTER_MASK, $this->decorator->getQueryParameters()[self::TEST_FILTER_FIELD]);
        }
    }

    /**
     * test filter for headers
     * 
     * @dataProvider credentialParameterProvider
     */
    public function testHeadersFilter($headers)
    {
        $this->instance->setHeaders($headers);

        if (array_key_exists(self::TEST_FILTER_FIELD, $headers)) {
            $this->assertNotEquals($headers, $this->decorator->getHeaders(), "", 0.0, 10, true, false);
            $this->assertSame(self::TEST_FILTER_MASK, $this->decorator->getHeaders()[self::TEST_FILTER_FIELD]);
        }
    }
    
    /**
     * Provides 2 example parameter arrays
     * @return array
     */
    public function parameterProvider()
    {
        return array(
            array(array(
                'Accept'    => 'Nothing',
                'Foo'       => 'Bar',
                'Feels'     => 'BadMan',
            )),
            array(array(
                'Decline'   => 'Nothing',
                'Bar'       => 'Foo',
            )),
        );
    }

    /**
     * Provides 3 example parameter arrays with sensetiv data
     * @return array
     */
    public function credentialParameterProvider()
    {
        return array(
            array(array(
                'Accept'    => 'Nothing',
                'Foo'       => 'Bar',
                'Feels'     => 'BadMan',
            )),
            array(array(
                'password'  => 'Nothing',
                'Bar'       => 'Foo',
            )),
            array(array(
                'password'  => 'foo-bar',
            )),
        );
    }
}
